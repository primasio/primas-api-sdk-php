<?php

namespace Primas;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Primas\Crypto\Keccak;
use Primas\Crypto\Signature;
use Primas\Exceptions\ErrorConfigException;
use Primas\Types\Byte;

abstract class PrimasClient
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * PrimasClient constructor.
     * @throws ErrorConfigException
     */
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
     * @param $function
     * @param $arguments
     * @throws ClientException
     * @return mixed
     */
    public function __call($function, $arguments)
    {
        $response = $this->client->$function(...$arguments);
        $content = $response->getBody()->getContents();
        return json_decode($content, true, 512, JSON_BIGINT_AS_STRING);
    }

    /**
     * @param array $metadata
     * @return string
     * @throws \Exception
     */
    protected function completeMetadata(array $metadata)
    {
        $metadata["address"] = (string)Keystore::getAddress();
        $signature = Signature::sign($this->generateMetadata($metadata), Keystore::getPrivateKey());
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
                if ($value === false) {
                    $str .= 'false'; //The booleans
                } elseif ($value === true) {
                    $str .= 'true'; //The booleans
                } elseif (is_int($value) || is_float($value)) {
                    $str .= $value; // Numbers
                } elseif (is_numeric($value) && ctype_digit($value) && gmp_cmp(gmp_abs($value), PHP_INT_MAX) > 0) {
                    $str .= $value; // Big Numbers
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