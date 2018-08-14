<?php

include __DIR__ . "/../vendor/autoload.php";
include "TestBase.php";

$URI="http://10.0.0.5:8080";
//$URI="";

define("BASE_URI",$URI);

$keyStorePath = __DIR__ . "/keystone";
$keyStore = file_get_contents($keyStorePath);
$password = "Test123:::";
\Primas\Kernel\Eth\Keystore::init($keyStore,$password);