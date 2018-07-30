<?php

namespace Primas;

/**
 * TimeLine  APIs
 *
 * Class TimeLine
 * @package Primas
 */
class TimeLine extends PrimasClient
{

    /**
     * Get account timeline
     *
     * @param string $account_id
     * @param array $parameters
     * @return mixed
     */
    public function getAccountTimeline(string $account_id, array $parameters = [])
    {
        $data = $this->get("/v3/accounts/$account_id/timeline" . "?" . $this->buildQuery($parameters));

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