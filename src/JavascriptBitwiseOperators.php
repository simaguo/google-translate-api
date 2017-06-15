<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/15
 * Time: 14:31
 */
class JavascriptBitwiseOperators
{

    private static function check64()
    {
        if (strlen(decbin(-1)) == 64) {
            return true;
        }
        return false;
    }

    /**
     * 获取32位补码
     * @param $a
     * @return bool|string
     */
    private static function get32ComplementNumber($a)
    {
        $a = (int)$a;
        $bin = decbin($a);
        if (strlen($bin) > 32) {
            $bin = substr($bin, -32);
        } else {
            $bin = str_pad($bin, 32, 0, STR_PAD_LEFT);
        }
        return $bin;
    }

    private static function get32TrueNumber($a)
    {

    }

    /**
     * 取反
     * @param $binary
     * @return string
     */
    private static function reverse($binary)
    {
        $rcode = '';
        foreach (str_split($binary) as $bit) {
            $rcode .= ($bit == 0 ? 1 : 0);
        }
        return $rcode;
    }


    /**
     * 获取符号字符串
     * @param $binary
     * @return string
     */
    private static function getSign($binary)
    {
        $sign = 1 == substr($binary, 1, 1) ? '-' : '';
        return $sign;
    }

    public static function notOperator($a)
    {
        if ($a >= 2147483648) {
            $res = $a % 2147483648 - 2147483648;
        } elseif ($a <= -2147483648) {
            $res = $a % 2147483648 + 2147483648;
        } else {
            $res = $a;
        }
        return ~$res;
    }

    public static function andOperator($a, $b)
    {

    }

    public static function orOperator($a, $b)
    {

    }

    public static function xorOperator($a, $b)
    {

    }

    public static function shiftLeftOperator($a, $b)
    {

    }

    public static function shiftRightOperator($a, $b)
    {

    }
}

echo JavascriptBitwiseOperators::notOperator(2147483647) . "\n";
echo JavascriptBitwiseOperators::notOperator(2147483648) . "\n";
echo JavascriptBitwiseOperators::notOperator(2147483649) . "\n";
echo JavascriptBitwiseOperators::notOperator(9) . "\n";
echo JavascriptBitwiseOperators::notOperator(-2147483647) . "\n";
echo JavascriptBitwiseOperators::notOperator(-2147483648) . "\n";
echo JavascriptBitwiseOperators::notOperator(-2147483649) . "\n";
echo JavascriptBitwiseOperators::notOperator(-21474836493) . "\n";
echo JavascriptBitwiseOperators::notOperator(21474836493) . "\n";