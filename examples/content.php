<?php

require_once "init.php";


$config = [
    "http_options" => [
        "base_uri" => BASE_URI
    ],
    "account_id" => $account_id
];
$app = \Primas\Factory::account($config);
// create
$parameters = [
    "version" => "1.0",
    "type" => "object",
    "tag" => "article",
    "title" => "content test",
    "creator" => [
        "account_id" => ""
    ],
    "abstract" => "abstract",
    "language" => "en-US",
    "category" => "test",
    "created" => time(),
    "content" => "first developer test content",
    "content_hash" => hash("sha256", "first developer test content"),
    "status" => "haha"
];
$metadataJson = $app->buildCreateAccount($parameters);
$signature = $app->sign($metadataJson);
$metadataJson = $app->afterSign($metadataJson);
$createRes = $app->createContent($metadataJson);
var_dump($createRes);


$content_id = "1GFYUNP815RUIFDNNRKLNU78RPCFLNL5DWGT7EXODHFVRCRVXJ";

$content = $app->getContent($content_id);
var_dump($content);