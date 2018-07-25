<?php


require_once __DIR__."/../vendor/autoload.php";


$context = secp256k1_context_create(SECP256K1_CONTEXT_SIGN | SECP256K1_CONTEXT_VERIFY);

$msg32 = hash('sha256', 'this is a message!', true);

//$msg32=\kornrunner\Keccak::hash("this",256);
echo strlen($msg32).PHP_EOL;
//$privateKey = pack("H*", "88b59280e39997e49ebd47ecc9e3850faff5d7df1e2a22248c136cbdd0d60aae");
do {
    $key = \openssl_random_pseudo_bytes(32);
} while (secp256k1_ec_seckey_verify($context, $key) == 0);
$privateKey=$key;
//$privateKey = unpack("H*", $key)[1];
//echo $privateKey.PHP_EOL;
/** @var resource $signature */
$signature = '';

if (1 !== secp256k1_ecdsa_sign($context, $signature, $msg32, $privateKey)) {
    throw new \Exception("Failed to create signature");
}

$serialized = '';
secp256k1_ecdsa_signature_serialize_der($context, $serialized, $signature);
$sign=bin2hex($serialized);
echo sprintf("Produced signature: %s \n", $sign);
echo sprintf("Produced signature length: %d \n", strlen($sign));
