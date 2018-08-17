<?php

include "init.php";

class TestAccount extends TestBase
{
    public function __construct()
    {
        $config = [
            "http_options" => [
                "base_uri" => BASE_URI,
            ],
            // You can use the account_id of the account you created
            // "account_id" => $account_id
        ];
        $this->app = \Primas\Factory::account($config);
    }

    public function testCreateAccount()
    {
        /*
         * some field like version、type... The SDK is already filling in the fixed values automatically
         */
        $parameters = [
            "name" => "Test:::123",
            "abstract" => "first test",
            "created" => time()
        ];
        $metadataJson = $this->app->buildCreateAccount($parameters);
        $sign = $this->app->sign($metadataJson);
        $metadata = $this->app->setSignature($metadataJson, $sign);
        // every keystore only can create one root account
        $res = $this->app->createAccount($metadata);
        if (isset($res["result_code"]) && $res["result_code"] == \Primas\Kernel\Code::OK) {
            $this->account_id = $res["data"]["id"];
        }
    }

    public function testCreateSubAccount($account_id)
    {
        $parameters = [
            "name" => "Test:::123",
            "abstract" => "first test",
            "created" => time(),
            "creator" => [
                "account_id" => $account_id,
                "sub_account_id" => "testsubaccount"
            ]
        ];
        $metadataJson = $this->app->buildCreateAccount($parameters);
        $sign = $this->app->sign($metadataJson);
        $metadata = $this->app->setSignature($metadataJson, $sign);
        // every keystore only can create one root account
        $res = $this->app->createAccount($metadata);
        return $res;
    }

    public function testGetAccountMetadata(){
        return $this->app->getAccountMetadata();
    }

    public function testGetSubAccountMetadata($subAccountId){
        return $this->app->getSubAccountMetadata($subAccountId);
    }

    public function testGetAccountCreditsList(){
        return $this->app->getAccountCreditsList();
    }

}