<?php

require_once __DIR__ . "/vendor/autoload.php";

$base_uri = "https://staging.primas.io";

\Primas\Primas::init([
    "base_uri" => $base_uri,
    "verify" => false
]);

$content_id = "1GFYUNP815RUIFDNNRKLNU78RPCFLNL5DWGT7EXODHFVRCRVXJ";
$content = new \Primas\Content();
$content=$content->getContent($content_id);
var_dump($content);