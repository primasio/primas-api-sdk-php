<?php

namespace Primas\Kernel\Traits;

use Primas\Kernel\Crypto\Keccak;
use Primas\Kernel\Crypto\Signature;
use Primas\Kernel\Eth\Keystore;
use Primas\Kernel\Support\Arr;
use Primas\Kernel\Support\Json;
use Primas\Kernel\Types\Byte;

/**
 * Trait Metadata
 * @package Primas\Kernel\Traits
 */
trait Metadata
{

    /**
     * @param array $data
     * @param array $filters
     * @return array
     */
    protected function initField(array $data, array $filters)
    {
        return array_merge($data, $filters);
    }

    /**
     * @param array $data
     * @return array
     */
    protected function removeFields(array $data)
    {
        $removeFields = ['signature'];
        foreach ($removeFields as $field) {
            if (isset($data[$field])) unset($data[$field]);
        }
        return $data;
    }

    /**
     * @param array $data
     * @param array $filters
     * @return string
     */
    protected function beforeSign(array $data, array $filters = [])
    {
        $metadata = $this->initField($this->removeFields(array_filter($data)), $filters);
        $metadata = Arr::ksort($metadata);
        $metadataJson = Json::json_encode($metadata);
        return $metadataJson;
    }

    /**
     * @param string $metadataJson
     * @return string
     * @throws \Exception
     */
    public function sign(string $metadataJson)
    {
        $signature = Signature::sign(Byte::initWithHex(Keccak::hash($metadataJson, 256), Keystore::getPrivateKey()))->getHex();
        return $signature;
    }

    /**
     * @param string $metadataJson
     * @param string $signature
     * @return string
     */
    public function afterSign(string $metadataJson, string $signature)
    {
        $metadata = Json::json_decode($metadataJson, true);
        $metadata["signature"] = $signature;
        return Json::json_encode($metadata);
    }
}