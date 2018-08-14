<?php

namespace Primas\Node;

use GuzzleHttp\Exception\ClientException;
use Primas\Kernel\BaseClient;
use Primas\Kernel\Support\Json;

/**
 * Node APIs
 *
 * Class Application
 * @package Primas\Node
 */
class Application extends BaseClient
{

    /**
     * get node lists
     *
     * @param array $parameters
     * @return mixed
     * @throws ClientException
     */
    public function getNodeLists(array $parameters = [])
    {
        $data = $this->get("nodes" . "?" . $this->buildQuery($parameters));

        return Json::json_decode($data,true);
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