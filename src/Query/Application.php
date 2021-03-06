<?php

namespace Primas\Query;

use GuzzleHttp\Exception\ClientException;
use Primas\Kernel\BaseClient;
use Primas\Kernel\Support\Json;

/**
 * Query APIs
 *
 * Class Application
 * @package Primas\Query
 */
class Application extends BaseClient
{

    /**
     * Query all APIs
     *
     * @param array $parameters
     * @return mixed
     * @throws ClientException
     */
    public function query(array $parameters = [])
    {
        $data = $this->get("query" . "?" . $this->buildQuery($parameters));

        return Json::json_decode($data, true);
    }

    /**
     * @param array $parameters
     * @return mixed
     * @throws ClientException
     */
    public function queryContent(array $parameters = [])
    {
        $data = $this->get("query/content" . "?" . $this->buildQuery($parameters));

        return Json::json_decode($data, true);
    }

    /**
     * @param array $parameters
     * @return mixed
     * @throws ClientException
     */
    public function queryReproductions(array $parameters)
    {
        $data = $this->get("query/reproductions" . "?" . $this->buildQuery($parameters));

        return Json::json_decode($data, true);
    }

    /**
     * @param array $parameters
     * @return string
     */
    private function buildQuery(array $parameters)
    {
        return http_build_query(array_filter($parameters, function ($k) {
            return in_array($k, ["page", "page_size", "text", "type", "category"]);
        }, ARRAY_FILTER_USE_KEY));
    }

}