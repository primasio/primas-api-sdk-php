<?php

include "init.php";

class TestQuery extends TestBase
{

    public function __construct()
    {
        $config = [
            "http_options" => [
                "base_uri" => BASE_URI,
            ],
            //  "account_id" => $account_id
        ];
        $this->app = \Primas\Factory::query($config);
    }

    public function testQuery()
    {
        $query = [];
        return $this->app->query($query);
    }

    public function testQueryReproductions($url)
    {
        $query = [
            "url" => urlencode($url)
        ];
        return $this->app->queryReproductions($query);
    }
}

$app = new TestQuery();
$data = $app->testQuery();
var_dump($data);