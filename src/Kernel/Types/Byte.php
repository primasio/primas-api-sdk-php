<?php

namespace Primas\Kernel\Types;

use Exception;
use Primas\Kernel\Support\Utils;

class Byte extends TypeAbstract
{
    /**
     * @param string|int $string
     * @return Byte
     */
    public static function init($string = ''): Byte
    {
        return new static(new Buffer($string));
    }

    /**
     * @param string $hex
     * @return Byte
     * @throws Exception
     */
    public static function initWithHex($hex): Byte
    {
        $hex = Utils::removeHexPrefix($hex);
        return new static(Buffer::hex($hex));
    }
}
