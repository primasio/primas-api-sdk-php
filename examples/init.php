<?php

require_once __DIR__ . "/../vendor/autoload.php";

define("BASE_URI","http://10.0.0.63:8080");
$keyStorePath = __DIR__ . "/keystone";
$keyStore = file_get_contents($keyStorePath);
$password = "Test123:::";
\Primas\Kernel\Eth\Keystore::init($keyStore,$password);