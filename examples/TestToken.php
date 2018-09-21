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
        $metadata = $this->app->setSignature($metadataJson, $sign);
        $data = $this->app->createIncentivesWithdrawal($metadata);
        return $data;
    }

    public function testCreatePreLockTokens()
    {
        // your account address
        $address = '0x2cbca948ef67f917ceadce8c685faf301bfe44cc';
        $parameters = [
            "amount"=> 120 ,                                      // Pre lock amount , type integer
            // you can use package ramsey/uuid to generate uuid
            "nonce" => \Ramsey\Uuid\Uuid::uuid4()->toString(),
            "address" => $address,                                // user account address
        ];
        $metadataJson = $this->app->buildTransaction($parameters);
        $sign = $this->app->sign($metadataJson);
        // Prelocking is different from other interfaces
        $data = $this->app->createPreLockTokens($parameters,$sign);
        return $data;
    }

    public function testGetPreTokenList()
    {
        return $this->app->getPreLockTokenList();
    }

}

$node_id = "58f47077984e5daa4d2ea46f2e689177a1655c1321544e69f851530a789e9fd7";

$account_id = "e89c51db3e8b1130944a1d98308ec101d0c01cce3407e2d3d5d71e7f19e5dea9";
$app = new TestToken($account_id);

/*$testCreatePreLockTokens = $app->testCreatePreLockTokens();
var_dump($testCreatePreLockTokens);*/

/*$testGetPreTokenList = $app->testGetPreTokenList();
var_dump($testGetPreTokenList);*/

$testGetAccountTokenData = $app->testGetAccountTokenData();
var_dump($testGetAccountTokenData);

/*$testCreateIncentivesWithdrawal = $app->testCreateIncentivesWithdrawal($node_id);

var_dump($testCreateIncentivesWithdrawal);

*/
