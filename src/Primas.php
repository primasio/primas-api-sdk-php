<?php

namespace Primas;

use Primas\Types\Byte;

class Primas
{
    /**
     * DTCP VERSION
     */
    const DTCP_VERSION = "1.0";

    /**
     * primas api request uri
     *
     * @var string
     */
    public static $baseUri;

    /**
     * primas api request ca verify
     *
     * @var mixed
     */
    public static $verify;

    /**
     * @var Byte
     */
    private static $privateKey;

    /**
     * @return Byte
     */
    public static function getPrivateKey()
    {
        return self::$privateKey;
    }

    /**
     * @param array $options
     * @param Byte|null $privateKey
     */
    public static function init(array $options, Byte $privateKey = null)
    {
        self::$baseUri = $options["base_uri"] ?? null;
        self::$verify = $options["verify"] ?? true;
        self::$privateKey = $privateKey;
    }

}