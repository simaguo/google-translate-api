<?php

namespace GoogleTranslateApi;

class Client
{

    public function translate($query)
    {
        //echo $this->shr32(-1240148506, 6);
        echo $this->getTKK();
        echo '<br />';
        echo $tk = $this->tk($query, $this->getTKK());
        exit;
        $tk = $this->tk($query, $this->getTKK());
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

    /**
     * javascript 左移运算 <<
     * @param $x
     * @param $bits
     * @return number
     */
    private function shl32($x,$bits)
    {
        $bin = decbin($x);
        $l = mb_strlen($bin);
        $signed = mb_substr($bin, 0, 1);
        if($l > 32){
            $bin = mb_substr($bin,-31);
        }else{
            $bin = str_pad(mb_substr($bin,1), 31, '0', STR_PAD_LEFT);
        }
        $pad = '';
        $bin = $signed.substr($bin.str_pad($pad,$bits,0,STR_PAD_RIGHT),-31);
        return bindec($bin);

    }

    /**
     * 无符号32位右移 ;模拟实现JS的>>>，无符号右移。实现原理，化为二进制，先右移，后补零。
     * @param mixed $x 要进行操作的数字，如果是字符串，必须是十进制形式
     * @param string $bits 右移位数
     * @return mixed 结果，如果超出整型范围将返回浮点数
     */
    private function unshr32($x, $bits)
    {
        // 位移量超出范围的两种情况
        if ($bits <= 0) {
            return $x;
        }
        if ($bits >= 32) {
            return 0;
        }
        //转换成代表二进制数字的字符串
        $bin = decbin($x);
        $l = mb_strlen($bin);
        //字符串长度超出则截取底32位，长度不够，则填充高位为0到32位
        if ($l > 32) {
            $bin = mb_substr($bin, $l - 32, 32);
        } elseif ($l < 32) {
            $bin = str_pad($bin, 32, '0', STR_PAD_LEFT);
        }
        //取出要移动的位数，并在左边填充0
        return bindec(str_pad(mb_substr($bin, 0, 32 - $bits), 32, '0', STR_PAD_LEFT));
    }

    private function shr32($x, $bits)
    {
        // 位移量超出范围的两种情况
        if ($bits <= 0) {
            return $x;
        }
        if ($bits >= 32) {
            return 0;
        }
        //转换成代表二进制数字的字符串
        $bin = decbin($x);
        $l = mb_strlen($bin);
        //字符串长度超出则截取底32位，长度不够，则填充高位为0到32位
        if ($l > 32) {
            $bin = mb_substr($bin, $l - 32, 32);
        } elseif ($l < 32) {
            $bin = str_pad($bin, 32, '0', STR_PAD_LEFT);
        }
        //取出要移动的位数，并在左边填充0
        return bindec(str_pad(mb_substr($bin, 0, 32 - $bits), 32, '0', STR_PAD_LEFT));
    }

    private function cipher($a, $b)
    {
        for ($d = 0; $d < strlen($b) - 2; $d += 3) {
            $c = substr($b, $d + 2, 1);
            $c = ord('a') <= ord($c) ? ord($c) - 87 : intval($c);
            //var_dump([$a,$c,'+' == substr($b, $d + 1, 1) ? $a >> $c : $a << $c]);
            $c = '+' == substr($b, $d + 1, 1) ? $this->unshr32($a,$c) : $a << $c;
            $a = '+' == substr($b, $d, 1) ? $a + $c & 4294967295 : $a ^ $c;
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
                    $g[$d++] = $c >> 6 | 192;
                } else {
                    if (55296 == ($c & 64512) && $f + 1 < strlen($a) && 56320 == (ord(substr($a, $f + 1, 1)) & 64512)) {
                        $c = 65536 + (($c & 1023) << 10) + ord(substr($a, ++$f, 1) & 1023);
                        $g[$d++] = $c >> 18 | 240;
                        $g[$d++] = $c >> 12 & 63 | 128;
                    } else {
                        $g[$d++] = $c >> 12 | 224;
                        $g[$d++] = $c >> 6 & 63 | 128;
                    }

                }
                $g[$d++] = $c & 63 | 128;
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
            $a = ($a & 2147483647) + 2147483648;
        }
        $a %= 1E6;
        return $a . '.' + ($a ^ $h);

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