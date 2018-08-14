<?php

namespace Primas\Content;

use GuzzleHttp\Exception\ClientException;
use Primas\Kernel\BaseClient;
use Primas\Kernel\Exceptions\NotAllowException;
use Primas\Kernel\Exceptions\ParameterException;
use Primas\Kernel\Support\Json;
use Primas\Kernel\Traits\MetadataTrait;
use Primas\Kernel\Types\Metadata;

/**
 * Content APIs
 *
 * Class Application
 * @package Primas\Content
 */
class Application extends BaseClient
{
    use MetadataTrait;
    /**
     * fixed to 'object'
     */
    const TYPE = 'object';
    /**
     * fixed to 'created'
     */
    const STATUS = 'created';

    /**
     * @param string $content_id
     * @return mixed
     * @throws ClientException
     */
    public function getContent(string $content_id)
    {
        $data = $this->get("content/$content_id");

        return Json::json_decode($data, true);
    }

    /**
     * @param string $content_id
     * @return string
     * @throws ClientException
     */
    public function getRawContent(string $content_id)
    {
        $data = $this->get("content/$content_id/raw");

        return $data;
    }

    /**
     * @param array $parameters
     * @return string
     * @throws ParameterException
     */
    public function buildCreateContent(array $parameters)
    {
        $filters = [
            "version" => self::DTCP_VERSION,
            "type" => self::TYPE,
            "status" => self::STATUS
        ];
        $items = ["tag", "title", "creator", "abstract", "language", "category", "created", "content_hash"];
        $this->checkParameters($parameters, $items);
        $content_type = $this->getHttpOptions()["headers"]["Content-Type"];
        if ($content_type === "multipart/form-data" && $parameters["tag"] === "image") {
            if (!(is_object($parameters["content"]) && ($parameters["content"] instanceof \CURLFile)) && !(is_string($parameters["content"]) && is_file($parameters["content"]))) {
                throw new ParameterException("The field content must be a file path or an object instance CURLFile when you use Content-Type:multipart/form-data !");
            }
        }
        return $this->beforeSign($parameters, $filters);
    }

    /**
     * override trait method
     *
     * @param array $data
     * @return array
     */
    public function removeFields(array $data)
    {
        $removeFields = ['signature', 'content'];
        foreach ($removeFields as $field) {
            if (isset($data[$field])) unset($data[$field]);
        }
        return $data;
    }

    /**
     * @param Metadata $metadata
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     * @throws ClientException
     */
    public function createContent(Metadata $metadata, array $parameters)
    {
        $metadataArr = $metadata->toFormParams();
        if(!isset($parameters["content"])){
            throw new ParameterException("The field content must exists!");
        }
        $metadataArr["content"] = $parameters["content"];
        $content_type = $this->getHttpOptions()["headers"]["Content-Type"];
        switch ($content_type) {
            case "application/json":
                $metadataArr["content"] = base64_encode($metadataArr["content"]);
                break;
            case "application/x-www-form-urlencoded":
                $metadataArr["content"] = base64_encode($metadataArr["content"]);
                $metadataArr["creator"] = json_encode($metadataArr["creator"]);
                break;
            case "multipart/form-data":
                $metadataArr["creator"] = json_encode($metadataArr["creator"]);
                break;
        }
        $metadata = Metadata::init($metadataArr);
        $data = $this->post("content", $metadata);

        return Json::json_decode($data, true);
    }

    /**
     * @param string $content_id
     * @throws NotAllowException
     * @throws ClientException
     */
    public function updateContent(string $content_id)
    {
        throw new NotAllowException("This method is not allowed in this version");
    }

}