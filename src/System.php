<?php

namespace Primas;

/**
 * System  APIs
 *
 * Class System
 * @package Primas
 */
class System extends PrimasClient
{

    /**
     * Get system parameters
     *
     * @param array $parameters
     * @return mixed
     */
    public function getSystemParameters(array $parameters)
    {
        $response = $this->client->get("/v3/system" . "?" . $this->buildQuery($parameters));
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
            return in_array($k, ["lock_amount_content", "lock_period_content", "lock_amount_group_join", "lock_amount_group_create", "consume_amount_report"]);
        }, ARRAY_FILTER_USE_KEY));
    }

}