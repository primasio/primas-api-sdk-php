<?php

require_once __DIR__ . "/vendor/autoload.php";

$base_uri = "https://staging.primas.io";
$keyStore = '{"version":3,"id":"e1a1909a-7a38-44aa-af04-61cd3a342008","address":"d75407ad8cabeeebfed78c4f3794208b3339fbf4","Crypto":{"ciphertext":"bcf8d3037432f731d3dbb0fde1b32be47faa202936c303ece7f53890a79f49d2","cipherparams":{"iv":"e28edaeff90032f24481c6117e593e01"},"cipher":"aes-128-ctr","kdf":"scrypt","kdfparams":{"dklen":32,"salt":"7d7c824367d7f6607128c721d6e1729abf706a3165384bbfc2aae80510ec0ce2","n":1024,"r":8,"p":1},"mac":"52f98caaa4959448ec612e4314146b6a2d5022d5394b77e31f5a79780079c22f"}}';
$password = "Test123:::";
$keyStore = new \Primas\Keystore($keyStore, $password);
$privateKey = $keyStore->getPrivateKey();

\Primas\Primas::init([
    "base_uri" => $base_uri,
    "verify" => true
],$privateKey);

//token test
$content_id="809a85f7ddf8ae5aaa49fe30be10e07e09156dc04166fab98bbd7bb42b2dc26c";
$token=new \Primas\Token();
$res=$token->getAccountTokensData($content_id);
$res2=$token->getIncentivesList($content_id);
var_dump($res,$res2);
exit;

// Account
// create
$account=new \Primas\Account();
$parameters=[
    "name"=> "Test:::123",
    "abstract"=>"first test",
    "created"=>time()
];
$res=$account->createAccount($parameters);
var_dump($res);
exit;

$content = new \Primas\Content();

// create
$parameters = [
    "version" => "1.0",
    "type" => "object",
    "tag" => "article",
    "title" => "content test",
    "creator" => [
        "account_id" => ""
    ],
    "abstract"=>"abstract",
    "language"=>"en-US",
    "category"=>"test",
    "created"=>time(),
    "content"=>"first developer test content",
    "content_hash"=>hash("sha256","first developer test content"),
    "status"=>"haha"
];
$createRes=$content->createContent($parameters);
var_dump($createRes);


$content_id = "1GFYUNP815RUIFDNNRKLNU78RPCFLNL5DWGT7EXODHFVRCRVXJ";

$content = $content->getContent($content_id);
var_dump($content);

