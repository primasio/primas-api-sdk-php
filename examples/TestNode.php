<?php

include "init.php";

class TestNode extends TestBase
{

    public function __construct()
    {
        $config = [
            "http_options" => [
                "base_uri" => BASE_URI,
            ],
//            "account_id" => $account_id
        ];
        $this->app = \Primas\Factory::node($config);
    }

    public function testGetNodeLists()
    {
        $query = [];
        return $this->app->getNodeLists($query);
    }
}

$app = new TestNode();
var_dump($app->testGetNodeLists());