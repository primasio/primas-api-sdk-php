<?php

$context = secp256k1_context_create(SECP256K1_CONTEXT_SIGN | SECP256K1_CONTEXT_VERIFY);
$msgByte = hash('sha256', json_encode('this is a message!'),true);
$privateKey = pack("H*", "e4ce35c1ccf7f5d79a838bd527a0888fefb1523ce2fca52abd681d0e493bd5ad");//与服务器采用同样的私钥
$sigFromServer = "3a6f21e17b981d8d08677e0d3010f3aa9c2b8844f0b583eb0f0d992592601c1c6698980277a4b401541250a192a316cb681e7571aa883d2974626f662c83fcc31c";//服务器签名结果
$signature = '';
//$msgByte = hex2bin($msg32);
if (secp256k1_ecdsa_sign_recoverable($context, $signature, $msgByte, $privateKey) != 1) {
throw new \Exception("Failed to create recoverable signature");
}
$recId = 0;
$output = '';
secp256k1_ecdsa_recoverable_signature_serialize_compact($context, $signature, $output, $recId);
$signatureNative = bin2hex($output).dechex($recId + 27);//本地签名结果
echo $signatureNative.PHP_EOL;
echo sprintf("Produced signature length: %d \n", strlen($signatureNative)).PHP_EOL;
if (strcmp($sigFromServer, $signatureNative) == 0) {//服务器签名和本地签名对比
echo "signature is right!";
} else {
echo "signature is wrong!";
}