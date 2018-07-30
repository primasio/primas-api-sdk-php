<?php

require_once "init.php";

// create
$account = new \Primas\Account();
$account_id = "32fc4139f7d0347ca9ea70d30caad45a5d90fc23aaefacedf6bff2746e2073f3";

$parameters = [
    "name" => "Test:::123",
    "abstract" => "first test",
    "created" => 1532941632,
    "creator" => [
        "account_id" => $account_id,
        "sub_account_id" => "testsubaccount"
    ]
];
$res = $account->createAccount($parameters);

var_dump($res);

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

$accountData = $account->getAccounts($account_id);
var_dump($accountData);

$subAccountData = $account->getSubAccounts($account_id, $subAccountId);
var_dump($subAccountData);

$accountCreditList = $account->getAccountCreditsList($account_id);
var_dump($accountCreditList);
