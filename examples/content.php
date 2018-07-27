<?php

require_once "init.php";

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
    "abstract" => "abstract",
    "language" => "en-US",
    "category" => "test",
    "created" => time(),
    "content" => "first developer test content",
    "content_hash" => hash("sha256", "first developer test content"),
    "status" => "haha"
];
$createRes = $content->createContent($parameters);
var_dump($createRes);


$content_id = "1GFYUNP815RUIFDNNRKLNU78RPCFLNL5DWGT7EXODHFVRCRVXJ";

$content = $content->getContent($content_id);
var_dump($content);