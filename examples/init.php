<?php

require_once __DIR__ . "/../vendor/autoload.php";

$base_uri = "http://10.18.20.38:8080";
$keyStorePath = __DIR__ . "/keystone";
$keyStore = file_get_contents($keyStorePath);
$password = "Test123:::";
$keyStore = new \Primas\Keystore($keyStore, $password);
$privateKey = $keyStore->getPrivateKey();

// primas init
\Primas\Primas::init([
    "base_uri" => $base_uri,
    "verify" => true
], $privateKey);