<?php

namespace Primas\Node;

use Primas\Kernel\BaseClient;

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
     */
    public function getNodeLists(array $parameters = [])
    {
        $data = $this->get("nodes" . "?" . $this->buildQuery($parameters));

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