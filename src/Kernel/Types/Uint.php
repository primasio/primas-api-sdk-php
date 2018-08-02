<?php

namespace Primas\Kernel\Types;

use Exception;
use Primas\Kernel\Support\Utils;

class Uint extends TypeAbstract
{
    /**
     * @param string|int $uint
     * @return Uint
     */
    public static function init($uint = 0): Uint
    {
        return new static(Buffer::int($uint));
    }

    /**
     * @param string $hex
     * @return Uint
     * @throws Exception
     */
    public static function initWithHex($hex): Uint
    {
        $hex = Utils::removeHexPrefix($hex);
        return new static(Buffer::hex($hex));
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->getInt();
    }
}
