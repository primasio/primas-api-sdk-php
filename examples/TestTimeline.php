<?php

include "init.php";

class TestTimeline extends TestBase{

    public function __construct($account_id)
    {
        $config = [
            "http_options" => [
                "base_uri" => BASE_URI,
            ],
            "account_id" => $account_id
        ];
        $this->app = \Primas\Factory::time_line($config);
    }

    public function testGetAccountTimeline(){
        $query=[];
        return $this->app->getAccountTimeline($query);
    }
}

$account_id="32fc4139f7d0347ca9ea70d30caad45a5d90fc23aaefacedf6bff2746e2073f3";
$app = new TestTimeline($account_id);
$data = $app->testGetAccountTimeline();
var_dump($data);