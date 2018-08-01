<?php

namespace Primas;

use Primas\Exceptions\NotAllowException;

/**
 * Content APIs
 *
 * Class ContentInteraction
 * @package Primas
 */
class Content extends PrimasClient
{
    /**
     * fixed to 'object'
     */
    const TYPE = 'object';
    /**
     * fixed to 'created'
     */
    const STATUS = 'created';

    /**
     * @param string $id
     * @return mixed
     */
    public function getContent(string $id)
    {
        $data = $this->get("content/$id");

        return $data;
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function getRawContent(string $id)
    {
        $data = $this->get("content/$id/raw");

        return $data;
    }

    /**
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */
    public function createContent(array $parameters)
    {
        $filters = [
            "version" => Primas::DTCP_VERSION,
            "type" => self::TYPE,
            "status" => self::STATUS
        ];
        $data = $this->post("content", [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => $this->generateData($parameters, $filters),
        ]);

        return $data;
    }

    /**
     * @param string $contet_id
     * @throws NotAllowException
     */
    public function updateContent(string $contet_id)
    {
        throw new NotAllowException("This method is not allowed in this version");
    }

    /**
     * @param array $data
     * @param array $filters
     * @return string
     * @throws \Exception
     */
    protected function generateData(array $data, array $filters)
    {
        $metadata = $this->initField($this->removeFields(array_filter($data)), $filters);
        return $this->completeMetadata($metadata);
    }

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

}