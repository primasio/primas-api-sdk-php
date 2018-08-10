<?php

namespace Primas\System;

use GuzzleHttp\Exception\ClientException;
use Primas\Kernel\BaseClient;

/**
 * System  APIs
 *
 * Class Application
 * @package Primas\System
 */
class Application extends BaseClient
{

    /**
     * Get system parameters
     *
     * @param array $parameters
     * @return mixed
     * @throws ClientException
     */
    public function getSystemParameters(array $parameters)
    {
        $data = $this->get("system" . "?" . $this->buildQuery($parameters));

        return $data;
    }

    /**
     * @param array $parameters
     * @return string
     */
    private function buildQuery(array $parameters)
    {
        return http_build_query(array_filter($parameters, function ($k) {
            return in_array($k, ["lock_amount_content", "lock_period_content", "lock_amount_group_join", "lock_amount_group_create", "consume_amount_report"]);
        }, ARRAY_FILTER_USE_KEY));
    }

}