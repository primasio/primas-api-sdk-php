<?php

include "init.php";

class TestAccount extends TestBase
{
    public function __construct($account_id = "")
    {
        $config = [
            "http_options" => [
                "base_uri" => BASE_URI,
            ],
            // You can use the account_id of the account you created
            "account_id" => $account_id
        ];
        $this->app = \Primas\Factory::account($config);
    }

    public function testCreateAccount($address)
    {
        /*
         * some field like version、type... The SDK is already filling in the fixed values automatically
         */
        $parameters = [
            "name" => "Test:::123",
            "abstract" => "first test",
            "address" => $address,
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
        return $res;
    }

    /**
     * get account_id from testCreateAccount
     *
     * @param $account_id
     * @return mixed
     * @throws Exception
     */
    public function testCreateSubAccount($account_id, $address)
    {
        $parameters = [
            "name" => "Test:::123",
            "abstract" => "first test",
            "created" => time(),
            "address" => $address,
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

    public function testGetAccountMetadata()
    {
        return $this->app->getAccountMetadata();
    }

    public function testGetSubAccountMetadata($subAccountId)
    {
        return $this->app->getSubAccountMetadata($subAccountId);
    }

    public function testGetAccountCreditsList()
    {
        return $this->app->getAccountCreditsList();
    }

    public function testGetAddressMetadata($address = '')
    {
        if (!$address) {
            $address = \Primas\Kernel\Eth\Keystore::getAddress();
        }
        return $this->app->getAddressMetadata($address);
    }

    public function testGetAccountGroupList()
    {
        return $this->app->getAccountGroupList();
    }

}

$account_id = "e89c51db3e8b1130944a1d98308ec101d0c01cce3407e2d3d5d71e7f19e5dea9";

$app = new TestAccount($account_id);
$address = \Primas\Kernel\Eth\Keystore::getAddress()->toString();

/*$res = $app->testCreateAccount($address);
var_dump($res);
$account_id = $res["data"]["id"];
var_dump($app->testCreateSubAccount($account_id,$address));*/

/*$data=$app->testGetAddressMetadata($address);
var_dump($data);*/

$data = $app->testGetAccountGroupList();
var_dump($data);
