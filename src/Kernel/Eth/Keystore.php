<?php

namespace Primas\Kernel\Eth;

use Primas\Kernel\Crypto\Keccak;
use Primas\Kernel\Types\Address;
use Primas\Kernel\Types\Byte;
use Exception;
use InvalidArgumentException;

class Keystore
{
    /**
     * @var Byte
     */
    private static $privateKey;
    /**
     * @var Byte
     */
    private static $publicKey;

    /**
     * @var Address
     */
    private static $address;

    /**
     * @param string $data
     * @param string $passphrase
     * @throws Exception
     */
    public static function init(string $data, string $passphrase)
    {

        $json = json_decode($data);
        if (property_exists($json, "Crypto")) {
            $crypto = "Crypto";
        } elseif (property_exists($json, "crypto")) {
            $crypto = "crypto";
        } else {
            throw new InvalidArgumentException('Argument is not a valid JSON string.');
        }
        $data = $json->$crypto;

        switch ($data->kdf) {
            case 'pbkdf2':
                $derivedKey = self::derivePbkdf2EncryptedKey(
                    $passphrase,
                    $data->kdfparams->prf,
                    $data->kdfparams->salt,
                    $data->kdfparams->c,
                    $data->kdfparams->dklen
                );
                break;
            case 'scrypt':
                $derivedKey = self::deriveScryptEncryptedKey(
                    $passphrase,
                    $data->kdfparams->salt,
                    $data->kdfparams->n,
                    $data->kdfparams->r,
                    $data->kdfparams->p,
                    $data->kdfparams->dklen
                );
                break;
            default:
                throw new Exception(sprintf('Unsupported KDF function "%s".', $data->kdf));
        }
        if (!self::validateDerivedKey($derivedKey, $data->ciphertext, $data->mac)) {
            throw new Exception('Passphrase is invalid.');
        }
        self::$privateKey = self::decryptPrivateKey($data->ciphertext, $derivedKey, $data->cipher, $data->cipherparams->iv);
        self::$publicKey = self::createPublicKey(self::$privateKey);
        self::$address = self::parseAddress(self::$publicKey);
    }

    /**
     * @param string $passphrase
     * @param string $prf
     * @param string $salt
     * @param int $c
     * @param $dklen
     * @return string
     * @throws Exception
     */
    private function derivePbkdf2EncryptedKey(string $passphrase, string $prf, string $salt, int $c, $dklen)
    {
        if ($prf != 'hmac-sha256') {
            throw new Exception(sprintf('Unsupported PRF function "%s".', $prf));
        }
        return hash_pbkdf2('sha256', $passphrase, pack('H*', $salt), $c, $dklen * 2);
    }

    /**
     * @param string $passphrase
     * @param string $salt
     * @param int $n
     * @param int $r
     * @param int $p
     * @param int $dklen
     * @return string
     */
    private function deriveScryptEncryptedKey(string $passphrase, string $salt, int $n, int $r, int $p, int $dklen)
    {
        return scrypt($passphrase, pack('H*', $salt), $n, $r, $p, $dklen);
    }

    /**
     * @param string $key
     * @param string $ciphertext
     * @param string $mac
     * @return bool
     * @throws Exception
     */
    private function validateDerivedKey(string $key, string $ciphertext, string $mac)
    {
        return Keccak::hash(pack('H*', substr($key, 32, 32) . $ciphertext)) === $mac;
    }

    /**
     * @param string $ciphertext
     * @param string $key
     * @param string $cipher
     * @param string $iv
     * @return Byte
     * @throws Exception
     */
    private function decryptPrivateKey(string $ciphertext, string $key, string $cipher, string $iv): Byte
    {
        $output = openssl_decrypt(pack('H*', $ciphertext), $cipher, pack('H*', substr($key, 0, 32)), OPENSSL_RAW_DATA, pack('H*', $iv));
        return Byte::init($output);
    }

    /**
     * @param Byte $privateKey
     * @return Byte
     * @throws Exception
     */
    private function createPublicKey(Byte $privateKey): Byte
    {
        $context = secp256k1_context_create(SECP256K1_CONTEXT_SIGN | SECP256K1_CONTEXT_VERIFY);
        /** @var resource $publicKey */
        $publicKey = null;
        $result = secp256k1_ec_pubkey_create($context, $publicKey, $privateKey->getBinary());
        if ($result === 1) {
            $serialized = '';
            if (1 !== secp256k1_ec_pubkey_serialize($context, $serialized, $publicKey, false)) {
                throw new Exception('secp256k1_ec_pubkey_serialize: failed to serialize public key');
            }
            $serialized = substr($serialized, 1, 64);
            unset($publicKey, $context);
            return Byte::init($serialized);
        }
        throw new Exception('secp256k1_pubkey_create: secret key was invalid');
    }

    /**
     * @param Byte $publicKey
     * @return Address
     * @throws Exception
     */
    private function parseAddress(Byte $publicKey): Address
    {
        $hash = Keccak::hash($publicKey->getBinary());
        return Address::init(substr($hash, -40, 40));
    }

    /**
     * @return Byte
     */
    public static function getPrivateKey(): Byte
    {
        return self::$privateKey;
    }

    /**
     * @return Address
     */
    public static function getAddress(): Address
    {
        return self::$address;
    }

    /**
     * @return Byte
     */
    public static function getPublicKey(): Byte
    {
        return self::$publicKey;
    }

}