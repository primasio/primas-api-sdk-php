<?php

require_once "init.php";

// create
$account = new \Primas\Account();
$parameters = [
    "name" => "Test:::123",
    "abstract" => "first test",
    "created" => time()
];
$res = $account->createAccount($parameters);
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
    string(64) "9afd45476bf50ac4034ee14f1b043ee1c480e3d7616ffdec108cec79116274b5"
        ["dna"]=>
    string(64) "d834cb6c5a5837eabb64a240564d9c52efefecf4560091788df6a2e6dec9a9fc"
  }
}
*/

$account_id = $res["data"]["id"];
$account_dna = $res["data"]["dna"];

// get

$accountData=$account->getAccounts($account_id);
var_dump($accountData);

$accountCreditList=$account->getAccountCreditsList($account_id);
var_dump($accountCreditList);
