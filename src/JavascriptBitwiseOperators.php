<?php
namespace GoogleTranslateApi;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/15
 * Time: 14:31
 */
class JavascriptBitwiseOperators
{

    private static function is64OS()
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
        $bin = decbin($a);
        if (strlen($bin) >= 32) {//负数
            return substr($bin, -32);
        } else {
            return str_pad($bin, 32, 0, STR_PAD_LEFT);
        }

    }


    /**
     * 获取符号字符串
     * @param $binary
     * @return string
     */
    private static function getSign($binary, $bool = false)
    {
        $sign = substr($binary, 0, 1);
        if ($bool) {
            return $sign;
        } else {
            return 1 == $sign ? '-' : '';
        }

    }

    private static function get31Binary($binary)
    {
        return substr($binary, -31);
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
     * 获取数字绝对值的二进制码
     * @param $a
     * @return string
     */
    private static function binary($a, $length = null, $char = 0)
    {
        $a = abs($a);
        $c = [];
        do {
            $c[] = $a % 2;
            $a = floor($a / 2);
        } while ($a);
        $binary = implode('', array_reverse($c));
        if (is_integer($length) && $length > strlen($binary)) {
            $binary = str_pad($binary, $length, $char, STR_PAD_LEFT);
        }
        return $binary;
    }

    public static function getValue($cn)
    {
        if ($cn === str_pad(1, 32, 0, STR_PAD_RIGHT)) {
            return -2147483648;
        }
        if ($cn === str_pad(0, 32, 0, STR_PAD_RIGHT)) {
            return 0;
        }
        $sign = self::getSign($cn);
        if ($sign === '-') {
            $otherBinary = self::get31Binary($cn);
            $val = intval(self::reverse(self::binary(intval($otherBinary, 2) - 1, 31)), 2);
        } else {
            $val = intval($cn, 2);
        }

        return intval($sign . $val);
    }

    public static function toInt32($a)
    {
        $cn = self::get32ComplementNumber($a);
        return self::getValue($cn);
    }

    /**
     * 位运算 NOT 由否定号（~）表示
     * @param $a
     * @return int
     */
    public static function notOperator($a)
    {
        $cn = self::get32ComplementNumber($a);
        $bin = self::reverse($cn);
        return self::getValue($bin);
    }

    /**
     * 位运算 AND 由和号（&）表示
     * @param $a
     * @param $b
     * @return int
     */
    public static function andOperator($a, $b)
    {
        $acn = str_split(self::get32ComplementNumber($a));
        $bcn = str_split(self::get32ComplementNumber($b));
        $c = [];
        for ($i = 0; $i < 32; $i++) {
            $c[] = ($acn[$i] == $bcn[$i] && $acn[$i] == 1) ? 1 : 0;
        }
        $c = implode('', $c);
        return self::getValue($c);
    }

    /**
     * 位运算 OR 由符号（|）表示
     * @param $a
     * @param $b
     * @return int
     */
    public static function orOperator($a, $b)
    {
        $acn = str_split(self::get32ComplementNumber($a));
        $bcn = str_split(self::get32ComplementNumber($b));
        $c = [];
        for ($i = 0; $i < 32; $i++) {
            $c[] = ($acn[$i] == 1 || $bcn[$i] == 1) ? 1 : 0;
        }
        $c = implode('', $c);
        return self::getValue($c);
    }

    /**
     * 位运算 XOR 由符号（^）表示
     * @param $a
     * @param $b
     * @return int
     */
    public static function xorOperator($a, $b)
    {
        $acn = str_split(self::get32ComplementNumber($a));
        $bcn = str_split(self::get32ComplementNumber($b));
        $c = [];
        for ($i = 0; $i < 32; $i++) {
            $c[] = ($acn[$i] != $bcn[$i]) ? 1 : 0;
        }
        $c = implode('', $c);
        return self::getValue($c);
    }


    /**
     * 左移运算由两个小于号表示（<<）
     * @param $a
     * @param $bit
     * @return int
     */
    public static function shiftLeftOperator($a, $bit)
    {
        $bit = $bit % 32;
        $cn = self::get32ComplementNumber($a);
        $cn = substr(str_pad($cn, 32 + $bit, 0, STR_PAD_RIGHT), -32);
        return self::getValue($cn);
    }

    //有符号右移运算符由两个大于号表示（>>）
    public static function shiftRightOperator($a, $bit)
    {
        $bit = $bit % 32;
        $cn = self::get32ComplementNumber($a);
        $sign = self::getSign($cn, true);

        $cn = substr(str_pad($cn, 32 + $bit, $sign, STR_PAD_LEFT), 0, 32);
        return self::getValue($cn);
    }

    //无符号右移运算符由两个大于号表示（>>>）
    public static function unSignedShiftRightOperator($a, $bit)
    {
        $bit = $bit % 32;
        $cn = self::get32ComplementNumber($a);
        $cn = substr(str_pad($cn, 32 + $bit, 0, STR_PAD_LEFT), 0, 32);
        return self::getValue($cn);
    }
}