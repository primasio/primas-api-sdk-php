<?php

namespace Primas;

/**
 * Node APIs
 *
 * Class Node
 * @package Primas
 */
class Node extends PrimasClient
{

    /**
     * get node lists
     *
     * @param array $parameters
     * @return mixed
     */
    public function getNodeLists(array $parameters = [])
    {
        $response = $this->client->get("/v3/nodes" . "?" . $this->buildQuery($parameters));
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
            return in_array($k, ["page", "page_size"]);
        }, ARRAY_FILTER_USE_KEY));
    }

}