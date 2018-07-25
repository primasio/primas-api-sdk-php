<?php


$context = secp256k1_context_create(SECP256K1_CONTEXT_SIGN | SECP256K1_CONTEXT_VERIFY);
$msg32 = sha3('this is a message!', 256);//这个消息是服务器返回的消息
$sigFromServer = "2b749c68b23c7ef5caaf64f15482862a0f14cf74a9bdf948e946eb25fcf02a0944bda9c190a35cef163278026501fa653bdfb4eb25a5b24647c474602a6cd4181b";//这个签名是服务器返回的签名
$pubKeyFromServer = "743352f77078a12f30d37d01783706d5b6dff809";//这个公钥是服务器返回的公钥
$msgByte = hex2bin($msg32);
$recId = hexdec(substr($sigFromServer, 128, 2)) - 27;
$siginput = hex2bin(substr($sigFromServer, 0, 128));
$signature = '';
secp256k1_ecdsa_recoverable_signature_parse_compact($context, $signature, $siginput, $recId);
$pubKey = '';
secp256k1_ecdsa_recover($context, $pubKey, $signature, $msgByte);
$serialized = '';
$compress = false;
secp256k1_ec_pubkey_serialize($context, $serialized, $pubKey, $compress);
$A = bin2hex($serialized);
$B = substr($A, 2, 128);//要去掉头两位，否则和Java端不一致
$pubkeyH = sha3(hex2bin($B), 256);
$pubkeyNative = substr($pubkeyH, 24, 40);//这个公钥是本地根据服务器签名和服务器返回的消息计算出来的
if (strcmp($pubKeyFromServer, $pubkeyNative) == 0) {//如果本地计算的公钥和服务器返回的公钥一致就说明签名正确
    echo "signature is verified!";
} else {
    echo "signature is wrong!";
}