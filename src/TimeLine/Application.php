<?php

namespace Primas\TimeLine;

use GuzzleHttp\Exception\ClientException;
use Primas\Kernel\BaseClient;

/**
 * TimeLine  APIs
 *
 * Class Application
 * @package Primas\TimeLine
 */
class Application extends BaseClient
{
    /**
     * Get account timeline
     *
     * @param array $parameters
     * @return mixed
     * @throws \Primas\Kernel\Exceptions\ErrorConfigException
     * @throws ClientException
     */
    public function getAccountTimeline(array $parameters = [])
    {
        $account_id = $this->getAccountId();
        $data = $this->get("accounts/$account_id/timeline" . "?" . $this->buildQuery($parameters));

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