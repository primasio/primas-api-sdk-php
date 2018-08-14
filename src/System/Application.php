<?php

namespace Primas\System;

use GuzzleHttp\Exception\ClientException;
use Primas\Kernel\BaseClient;
use Primas\Kernel\Support\Json;

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
     * @return mixed
     * @throws ClientException
     */
    public function getSystemParameters()
    {
        $data = $this->get("system");

        return Json::json_decode($data,true);
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