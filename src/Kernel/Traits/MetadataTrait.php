<?php

namespace Primas\Kernel\Traits;

use Primas\Kernel\Crypto\Keccak;
use Primas\Kernel\Crypto\Signature;
use Primas\Kernel\Eth\Keystore;
use Primas\Kernel\Support\Arr;
use Primas\Kernel\Support\Json;
use Primas\Kernel\Types\Byte;
use Primas\Kernel\Types\Metadata;

/**
 * Trait Metadata
 * @package Primas\Kernel\Traits
 */
trait MetadataTrait
{

    /**
     * @param array $data
     * @param array $filters
     * @return array
     */
    private function initField(array $data, array $filters): array
    {
        return array_merge($data, $filters);
    }

    /**
     * @param array $data
     * @return array
     */
    protected function removeFields(array $data): array
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
    protected function getRawMetadata(array $data, array $filters = []): string
    {
        $metadata = $this->initField($this->removeFields($this->filterEmptyValue($data)), $filters);
        $metadata = Arr::ksort($metadata);
        $metadataJson = Json::json_encode($metadata);
        return $metadataJson;
    }

    /**
     * @param array $array
     * @return array
     */
    protected function filterEmptyValue(array $array)
    {
        foreach ($array as $k => $v) {
            if (!$v) {
                unset($array[$k]);
            } elseif (is_array($v)) {
                $array[$k] = self::filterEmptyValue($array[$k]);
            }
        }
        return $array;
    }

    /**
     * @param string $metadataJson
     * @return string
     * @throws \Exception
     */
    public function sign(string $metadataJson): string
    {
        $signature = Signature::sign(Byte::initWithHex(Keccak::hash($metadataJson, 256)), Keystore::getPrivateKey())->getHex();
        return $signature;
    }

    /**
     * @param string $metadataJson
     * @param string $signature
     * @return Metadata
     */
    public function setSignature(string $metadataJson, string $signature): Metadata
    {
        $metadata = Json::json_decode($metadataJson, true);
        $metadata["signature"] = $signature;
        return Metadata::init($metadata);
    }

}