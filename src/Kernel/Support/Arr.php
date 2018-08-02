<?php

namespace Primas\Kernel\Support;

class Arr
{
    /**
     * @param array $arr
     * @return array
     */
    public static function ksort(array $arr)
    {
        ksort($arr);
        foreach ($arr as $k => $v) {
            if (is_array($v)) {
                $arr[$k] = self::ksort($v);
            }
        }
        return $arr;
    }
}
