<?php

namespace Primas;

/**
 * Query APIs
 *
 * Class Query
 * @package Primas
 */
class Query extends PrimasClient
{

    /**
     * Query all APIs
     *
     * @param array $parameters
     * @return mixed
     */
    public function query(array $parameters = [])
    {
        $response = $this->client->get("/v3/query" . "?" . $this->buildQuery($parameters));
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
        return $data;
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