<?php

namespace GoogleTranslateApi;

use GoogleTranslateApi\JavascriptBitwiseOperators as JBO;

class Client
{

    public function translate($query)
    {
        require 'JavascriptBitwiseOperators.php';
        //echo $this->shr32(-1240148506, 6);
        $tkk = $this->getTKK();
        $tk = $this->tk($query, $tkk);
        $url = 'https://translate.google.cn/translate_a/single?client=t&sl=auto&tl=zh-CN&hl=zh-CN&dt=at&dt=bd&dt=ex&dt=ld&dt=md&dt=qca&dt=rw&dt=rm&dt=ss&dt=t&ie=UTF-8&oe=UTF-8&otf=1&ssel=3&tsel=3&kc=1&tk=' . $tk . '&q=' . rawurlencode($query);

        return $this->curlGet($url, $this->getOption());
    }

    protected function getOption()
    {
        $option = array(
            'User-Agent:Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.86 Safari/537.36',
            'Accept-Language:zh-CN,zh;q=0.8'
        );
        return $option;
    }


    private function cipher($a, $b)
    {
        for ($d = 0; $d < strlen($b) - 2; $d += 3) {
            $c = substr($b, $d + 2, 1);
            $c = ord('a') <= ord($c) ? ord($c) - 87 : intval($c);
            //var_dump([$a,$c,'+' == substr($b, $d + 1, 1) ? $a >> $c : $a << $c]);
            $c = '+' == substr($b, $d + 1, 1) ? JBO::unSignedShiftRightOperator($a, $c) : JBO::shiftLeftOperator($a,
                $c);
            $a = '+' == substr($b, $d, 1) ? JBO::andOperator($a + $c, 4294967295) : JBO::xorOperator($a, $c);
            //var_dump([$c,$a]);
        }
        return $a;

    }

    private function tk($query, $tkk)
    {
        $a = $query;
        $e = explode('.', $tkk);
        $h = intval($e[0]) ? intval($e[0]) : 0;
        $g = [];
        $d = 0;
        for ($f = 0; $f < strlen($a); $f++) {
            $c = ord(substr($a, $f, 1));
            if (128 > $c) {
                $g[$d++] = $c;
            } else {
                if (2048 < $c) {
                    $g[$d++] = JBO::orOperator(JBO::shiftRightOperator($c, 6), 192);//$c >> 6 | 192;
                } else {
                    if (55296 == (JBO::andOperator($c,
                            64512)) && $f + 1 < strlen($a) && 56320 == JBO::andOperator(ord(substr($a, $f + 1, 1)),
                            64512)
                    ) {
                        $c = 65536 + JBO::shiftLeftOperator(JBO::andOperator($c, 1023),
                                10) + ord(JBO::andOperator(substr($a, ++$f, 1), 1023));
                        $g[$d++] = JBO::orOperator(JBO::shiftRightOperator($c,18),240);//$c >> 18 | 240;
                        $g[$d++] = JBO::orOperator(JBO::andOperator(JBO::shiftRightOperator($c , 12) , 63) , 128);//
                    } else {
                        $g[$d++] = JBO::orOperator(JBO::shiftRightOperator($c,12),224);//$c >> 12 | 224;
                        $g[$d++] = JBO::orOperator(JBO::andOperator(JBO::shiftRightOperator($c , 6) , 63) , 128);//$c >> 6 & 63 | 128;
                    }

                }
                $g[$d++] = JBO::orOperator(JBO::andOperator($c,63),128);//$c & 63 | 128;
            }

        }

        $a = $h;
        for ($d = 0; $d < count($g); $d++) {
            $a += $g[$d];
            $a = $this->cipher($a, "+-a^+6");
        }
        $a = $this->cipher($a, "+-3^+b+-f");
        $a ^= intval($e[1]) ? intval($e[1]) : 0;
        if (0 > $a) {
            $a = JBO::andOperator($a , 2147483647) + 2147483648;
        }
        $a %= 1E6;
        return $a . '.' . JBO::xorOperator($a , $h);

    }

    protected function getTKK()
    {
        $response = $this->curlGet('https://translate.google.cn', $this->getOption());

        if (preg_match("/TKK=eval\('(.*?)'\);/", $response, $arr)) {
            $func = stripcslashes($arr[1]);
            preg_match('/var a\\x3d(-?\d*?);var b\\x3d(-?\d*?);return (-?\d*?)\+/', $func, $nums);
            if (!$nums || count($nums) != 4) {
                preg_match('/var a=(-?\d*?);var b=(-?\d*?);return (-?\d*?)\+/', $func, $nums);
            }
            $a = $nums[1];
            $b = $nums[2];
            $c = $nums[3];
            $tkk = $c . '.' . ($a + $b);
            return $tkk;
        }
        throw new \Exception('can\'t find TKK');
    }

    protected function curlGet($url, $option = array(), $time = 3)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $time);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $option);
        $ret = curl_exec($ch);
        curl_close($ch);
        return $ret;
    }

    protected function curlPost($url, $data, $raw = true, $option = array(), $time = 3)
    {
        $data = $raw ? rawurldecode(http_build_query($data)) : http_build_query($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $time);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $option);
        $ret = curl_exec($ch);
        curl_close($ch);
        return $ret;
    }


}