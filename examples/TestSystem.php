<?php

include "init.php";

class TestSystem extends TestBase{

    public function __construct()
    {
        $config = [
            "http_options" => [
                "base_uri" => BASE_URI,
            ],
           // "account_id" => $account_id
        ];
        $this->app = \Primas\Factory::system($config);
    }

    public function testGetSystemParameters(){
        return $this->app->getSystemParameters();
    }
}

$app = new TestSystem();
$data = $app->testGetSystemParameters();
var_dump($data);