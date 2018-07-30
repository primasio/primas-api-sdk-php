<?php

require_once __DIR__ . "/../vendor/autoload.php";

$base_uri = "http://10.0.0.63:8080";
$keyStorePath = __DIR__ . "/keystone";
$keyStore = file_get_contents($keyStorePath);
$password = "Test123:::";
\Primas\Keystore::init($keyStore,$password);

// primas init
\Primas\Primas::init([
    "base_uri" => $base_uri,
    "verify" => true
]);