<?php

namespace Primas\Content;

use GuzzleHttp\Exception\ClientException;
use Primas\Kernel\BaseClient;
use Primas\Kernel\Exceptions\NotAllowException;
use Primas\Kernel\Exceptions\ParameterException;
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

        return $data;
    }

    /**
     * @param string $content_id
     * @return mixed
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
        if (!isset($parameters["content"])) {
            throw new ParameterException("content field is should");
        }
        $content_type = $this->getHttpOptions()["headers"]["Content-Type"];
        if($content_type === "application/json"){
            $parameters["content"] = base64_encode($parameters["content"]);
        }
        return $this->beforeSign($parameters, $filters);
    }

    /**
     * @param Metadata $metadata
     * @return mixed
     * @throws \Exception
     * @throws ClientException
     */
    public function createContent(Metadata $metadata)
    {
        $data = $this->post("content", $metadata);

        return $data;
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