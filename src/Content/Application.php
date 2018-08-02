<?php

namespace Primas\Content;

use Primas\Kernel\BaseClient;
use Primas\Kernel\Exceptions\NotAllowException;
use Primas\Kernel\Traits\Metadata;

/**
 * Content APIs
 *
 * Class Application
 * @package Primas\Content
 */
class Application extends BaseClient
{
    use Metadata;
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
     */
    public function getContent(string $content_id)
    {
        $data = $this->get("content/$content_id");

        return $data;
    }

    /**
     * @param string $content_id
     * @return mixed
     */
    public function getRawContent(string $content_id)
    {
        $data = $this->get("content/$content_id/raw");

        return $data;
    }

    /**
     * @param array $parameters
     * @return string
     */
    public function buildCreateContent(array $parameters)
    {
        $filters = [
            "version" => self::DTCP_VERSION,
            "type" => self::TYPE,
            "status" => self::STATUS
        ];
        return $this->beforeSign($parameters, $filters);
    }

    /**
     * @param string $metadataJson
     * @return mixed
     * @throws \Exception
     */
    public function createContent(string $metadataJson)
    {
        $data = $this->post("content", [
            'body' => $metadataJson,
        ]);

        return $data;
    }

    /**
     * @param string $content_id
     * @throws NotAllowException
     */
    public function updateContent(string $content_id)
    {
        throw new NotAllowException("This method is not allowed in this version");
    }

}