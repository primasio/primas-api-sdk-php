<?php

require_once "init.php";

//token test
$account_id = "809a85f7ddf8ae5aaa49fe30be10e07e09156dc04166fab98bbd7bb42b2dc26c";
$config = [
    "http_options" => [
        "base_uri" => BASE_URI
    ],
    "account_id" => $account_id
];
$token = \Primas\Factory::token($config);
$res = $token->getAccountTokensData();
$res2 = $token->getIncentivesList();
$res3 = $token->getIncentivesStatisticsList();
$res4 = $token->getIncentivesWithdrawalList();
$res5 = $token->getLockTokensList();
$res6 = $token->getPreLockTokenList();
var_dump($res, $res2, $res3, $res4, $res5, $res6);
exit;
$parameters = [
    "node_id" => "58f47077984e5daa4d2ea46f2e689177a1655c1321544e69f851530a789e9fd7",
    "amount" => "3219223372036854775807",   // php not support bigint type use string replace
    "created" => 1532525161,
    "node_fee" => "1239223372036854775807"  // php not support bigint type use string replace
];
$res7 = $token->createIncentivesWithdrawal($account_id, $parameters);
$transaction = [
    "id" => "",
    "block_number" => 1,
    "block_confirmations" => 1,
    "estimated_time" => 1,
    "confirmed_time" => time()
];
$res8 = $token->createPreLockTokens($account_id, $transaction);

var_dump($res, $res2, $res3, $res4, $res5, $res6, $res7);
exit;