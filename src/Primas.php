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
     * Server version
     */
    const SERVER_VERSION = "v3";

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
     * primas api request timeout
     *
     * @var mixed
     */
    public static $timeout;

    /**
     * @param array $options
     */
    public static function init(array $options)
    {
        self::$baseUri = $options["base_uri"] . "/" . self::SERVER_VERSION . "/" ?? null;
        self::$verify = $options["verify"] ?? true;
        self::$timeout = $options["timeout"] ?? 0;
    }

}