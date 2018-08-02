<?php

namespace Primas\Kernel\Support;

class Json
{

    /**
     * rewrite json_encode function (Big Integer)
     *
     * @param array $arr
     * @return string
     */
    public static function json_encode(array $arr)
    {
        $parts = array();
        $is_list = false;
        //Find out if the given array is a numerical array
        $keys = array_keys($arr);
        $max_length = count($arr) - 1;
        if (($keys [0] === 0) && ($keys [$max_length] === $max_length)) { //See if the first key is 0 and last key is length - 1
            $is_list = true;
            for ($i = 0; $i < count($keys); $i++) { //See if each key correspondes to its position
                if ($i != $keys [$i]) { //A key fails at position check.
                    $is_list = false; //It is an associative array.
                    break;
                }
            }
        }
        foreach ($arr as $key => $value) {
            if (is_array($value)) { //Custom handling for arrays
                if ($is_list)
                    $parts [] = self::json_encode($value); /* :RECURSION: */
                else
                    $parts [] = '"' . $key . '":' . self::json_encode($value); /* :RECURSION: */
            } else {
                $str = '';
                if (!$is_list)
                    $str = '"' . $key . '":';
                //Custom handling for multiple data types
                if ($value === false) {
                    $str .= 'false'; //The booleans
                } elseif ($value === true) {
                    $str .= 'true'; //The booleans
                } elseif (is_int($value) || is_float($value)) {
                    $str .= $value; // Numbers
                } elseif (is_numeric($value) && ctype_digit($value) && gmp_cmp(gmp_abs($value), PHP_INT_MAX) > 0) {
                    $str .= $value; // Big Numbers
                } else {
                    $str .= '"' . addcslashes($value, "\\\"\n\r\t/") . '"'; //All other things
                }
                // :TODO: Is there any more datatype we should be in the lookout for? (Object?)
                $parts [] = $str;
            }
        }
        $json = implode(',', $parts);
        if ($is_list)
            return '[' . $json . ']'; //Return numerical JSON
        return '{' . $json . '}'; //Return associative JSON
    }

    public static function json_decode(string $json, bool $assoc = false, int $depth = 512, int $options = JSON_BIGINT_AS_STRING)
    {
        return json_decode($json, $assoc, $depth, $options);
    }
}