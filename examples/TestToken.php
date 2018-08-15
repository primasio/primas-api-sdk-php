<?php

include "init.php";

class TestToken extends TestBase
{

    public function __construct($account_id)
    {
        $config = [
            "http_options" => [
                "base_uri" => BASE_URI,
                "headers" => [
                   "Content-Type" => "application/x-www-form-urlencoded"
               ]
                /*"headers" => [
                    "Content-Type" => "multipart/form-data"
                ]*/
            ],
            "account_id" => $account_id
        ];
        $this->app = \Primas\Factory::token($config);
    }

    public function testGetAccountTokenData()
    {
        return $this->app->getAccountTokensData();
    }

    public function testCreateIncentivesWithdrawal($node_id)
    {
        $parameters = [
            "node_id" => $node_id,
            "amount" => "32192233720368547758075548440005",   // php not support bigint type use string replace
            "created" => time(),
            "node_fee" => "1239223372036854775807545455744"  // php not support bigint type use string replace
        ];
        $metadataJson = $this->app->buildCreateIncentivesWithdrawal($parameters);
        $sign = $this->app->sign($metadataJson);
        $metadata = $this->app->afterSign($metadataJson, $sign);
        $data = $this->app->createIncentivesWithdrawal($metadata);
        return $data;
    }

    public function testCreatePreLockTokens()
    {
        $parameters = [
            "amount"=>"32192233720368547758075548440005" ,   // Pre lock amount ,php not support bigint type use string replace
            "nonce" => "1",  // User operator nonce id
        ];
        $metadataJson = $this->app->buildTransaction($parameters);
        $sign = $this->app->sign($metadataJson);
        $metadata = $this->app->afterSign($metadataJson, $sign);
        $data = $this->app->createPreLockTokens($metadata);
        return $data;
    }

}

$node_id = "58f47077984e5daa4d2ea46f2e689177a1655c1321544e69f851530a789e9fd7";

$account_id = "32fc4139f7d0347ca9ea70d30caad45a5d90fc23aaefacedf6bff2746e2073f3";
$app = new TestToken($account_id);
$testGetAccountTokenData = $app->testGetAccountTokenData();
var_dump($testGetAccountTokenData);

$testCreateIncentivesWithdrawal = $app->testCreateIncentivesWithdrawal($node_id);

var_dump($testCreateIncentivesWithdrawal);

$testCreatePreLockTokens = $app->testCreatePreLockTokens();
var_dump($testCreatePreLockTokens);
