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
     * @param array $metadata
     * @return string
     * @throws \Exception
     */
    protected function completeMetadata(array $metadata){
        $signature = Signature::sign($this->generateMetadata($metadata), Primas::getPrivateKey());
        $metadata["signature"] = $signature->getHex();
        return json_encode($metadata, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    /**
     * @param array $data
     * @return Byte
     * @throws \Exception
     */
    private function generateMetadata(array $data)
    {
        $metadata = self::ksort($data);
        $metadataJson = json_encode($metadata, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP);
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

}