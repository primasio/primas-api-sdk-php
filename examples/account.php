<?php

require_once "init.php";

$account_id = "809a85f7ddf8ae5aaa49fe30be10e07e09156dc04166fab98bbd7bb42b2dc26c";
$config = [
    "http_options" => [
        "base_uri" => BASE_URI,
        "headers" => [
            "Content-type"=>"application/json"
        ]
    ],
    "account_id" => $account_id
];

// create
$app = \Primas\Factory::account($config);

$parameters = [
    "name" => "Test:::123",
    "abstract" => "first test",
    "created" => 1532941632,
    "creator" => [
        "account_id" => $account_id,
        "sub_account_id" => "testsubaccount"
    ]
];
$metadataJson=$app->buildCreateAccount($parameters);
$sign=$app->sign($metadataJson);
$metadata=$app->afterSign($metadataJson,$sign);
$res = $app->createAccount($metadata);

var_dump($res);

exit;

// 结果
/*
 array(3) {
  ["result_code"]=>
  int(0)
  ["result_msg"]=>
  string(7) "success"
  ["data"]=>
  array(2) {
    ["id"]=>
    string(64) "e19aa9a8cdc217c345925b7e824baea0ef6dab0e11117dfd2746be469b412724"
    ["dna"]=>
    string(64) "4659b4848c8e9e3ec60c94ded2cc58a35419411f58ff27dc51f116bb05577eb9"
  }
}
*/

$account_dna = "4659b4848c8e9e3ec60c94ded2cc58a35419411f58ff27dc51f116bb05577eb9";
$subAccountId = "testsubaccount";

// get

$accountData = $account->getAccounts();
var_dump($accountData);

$subAccountData = $account->getSubAccounts($subAccountId);
var_dump($subAccountData);

$accountCreditList = $account->getAccountCreditsList();
var_dump($accountCreditList);
