<?php

namespace Primas;

use GuzzleHttp\Client;
use Primas\Crypto\Keccak;
use Primas\Crypto\Signature;
use Primas\Exceptions\ErrorConfigException;
use Primas\Types\Byte;

abstract class PrimasClient
{
    protected $client;

    public function __construct()
    {
        if (!Primas::$baseUri) {
            throw new ErrorConfigException("unset request base uri");
        }
        $this->client = new Client([
            'base_uri' => Primas::$baseUri,
            'verify' => Primas::$verify
        ]);
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        $response = $this->client->$name($arguments);
        $content = $response->getBoby()->getContent();
        return json_decode($content, true, 512, JSON_BIGINT_AS_STRING);
    }

    /**
     * @param array $metadata
     * @return string
     * @throws \Exception
     */
    protected function completeMetadata(array $metadata)
    {
        $signature = Signature::sign($this->generateMetadata($metadata), Primas::getPrivateKey());
        $metadata["signature"] = $signature->getHex();
        return self::json_encode($metadata);
    }

    /**
     * @param array $data
     * @return Byte
     * @throws \Exception
     */
    private function generateMetadata(array $data)
    {
        $metadata = self::ksort($data);
        $metadataJson = self::json_encode($metadata);
        return Byte::initWithHex(Keccak::hash($metadataJson, 256));
    }

    /**
     * @param array $arr
     * @return array
     */
    private function ksort(array $arr)
    {
        ksort($arr);
        foreach ($arr as $k => $v) {
            if (is_array($v)) {
                $arr[$k] = self::ksort($v);
            }
        }
        return $arr;
    }

    /**
     * 自写json方法满足需求
     *
     * @param array $arr
     * @return string
     */
    private static function json_encode(array $arr)
    {
        $parts = array();
        $is_list = false;
        //Find out if the given array is a numerical array
        $keys = array_keys($arr);
        $max_length = count($arr) - 1;
        if (($keys [0] === 0) && ($keys [$max_length] === $max_length)) { //See if the first key is 0 and last key is length - 1
            $is_list = true;
            for ($i = 0; $i < count($keys); $i++) { //See if each key correspondes to its position
                if ($i != $keys [$i]) { //A key fails at position check.
                    $is_list = false; //It is an associative array.
                    break;
                }
            }
        }
        foreach ($arr as $key => $value) {
            if (is_array($value)) { //Custom handling for arrays
                if ($is_list)
                    $parts [] = self::json_encode($value); /* :RECURSION: */
                else
                    $parts [] = '"' . $key . '":' . self::json_encode($value); /* :RECURSION: */
            } else {
                $str = '';
                if (!$is_list)
                    $str = '"' . $key . '":';
                //Custom handling for multiple data types
                if (is_int($value) || is_float($value) || (is_numeric($value) && is_string($value) && gmp_cmp(gmp_abs($value), "9223372036854775807") > 0)) {
                    $str .= $value; // Numbers
                } elseif ($value === false) {
                    $str .= 'false'; //The booleans
                } elseif ($value === true) {
                    $str .= 'true'; //The booleans
                } else {
                    $str .= '"' . addcslashes($value, "\\\"\n\r\t/") . '"'; //All other things
                }
                // :TODO: Is there any more datatype we should be in the lookout for? (Object?)
                $parts [] = $str;
            }
        }
        $json = implode(',', $parts);
        if ($is_list)
            return '[' . $json . ']'; //Return numerical JSON
        return '{' . $json . '}'; //Return associative JSON
    }

}