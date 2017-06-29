<?php

namespace Simaguo\GoogleTranslateApi;

use Simaguo\JavascriptBitwiseOperators\Tool;

class Client
{
    public $host = 'https://translate.google.cn';
    public $path = '/translate_a/single';
    protected $model = MODEL_SIMPLE;

    public $option;

    public $client = 't';
    public $sl = 'auto';//源语言 source language code
    public $tl = 'zh-CN';//目标语言 translation language
    public $hl = 'zh-CN';//语言
    /*
     may be included more than once and specifies what to return in the reply.Here are some values for dt. If the value is set, the following data will be returned:
    t - translation of source text
    at - alternate translations
    rm - transcription / transliteration of source and translated texts
    bd - dictionary, in case source text is one word (you get translations with articles, reverse translations, etc.)
    md - definitions of source text, if it's one word
    ss - synonyms of source text, if it's one word
    ex - examples
    rw - See also list.
     */
    public $dt = ['at', 'bd', 'ex', 'ld', 'md', 'qca', 'rw', 'rm', 'ss', 't'];
    public $ie = 'UTF-8'; //input encoding (a guess)
    public $oe = 'UTF-8'; //output encoding (a guess)
    public $source = 'btn';
    public $otf = 1;
    public $ssel = 0;
    public $tsel = 0;
    public $kc = 1;
    public $tk;
    public $tkk;
    public $q;//源文本字符串 source text / word

    public function __construct($query = '', $sl = '', $tl = '', $model = MODEL_SIMPLE)
    {

        if ($query) {
            $this->q = $query;
        }
        $this->from($sl);
        $this->to($tl);
        $this->model($model);
        $this->tkk = $this->getTkk();
    }


    public function from($sl = '')
    {
        if ($sl) {
            $this->sl = $sl;
        }
        return $this;
    }

    public function to($tl = '')
    {
        if ($tl) {
            $this->tl = $tl;
        }
        return $this;
    }

    public function hl($hl = '')
    {
        if ($hl) {
            $this->hl = $hl;
        }
        return $this;
    }

    public function model($model)
    {
        if ($model) {
            $this->model = $model;
        }
        return $this;
    }

    public function dt($dt = null)
    {
        $default = ['at', 'bd', 'ex', 'ld', 'md', 'qca', 'rw', 'rm', 'ss', 't'];

        if (is_array($dt)) {
            $value = [];
            foreach ($dt as $one) {
                if (in_array($one, $default)) {
                    $value[] = $one;
                }
            }
            $this->dt = $value;
        } else {
            if (in_array($dt, $default)) {
                $this->dt = $dt;
            }
        }
        return $this;
    }


    public function setOption($option = array())
    {
        if ($option) {
            $this->option = $option;
        }
        return $this;
    }


    public function translate($query = '', $model = MODEL_SIMPLE)
    {
        if ($query) {
            $this->q = $query;
        }

        $this->model($model);

        $this->tk = $this->tk($this->q, $this->tkk);

        $url = $this->getQueryUrl();

        $result = $this->curlGet($url, $this->getOption());

        return $this->filter($result);
    }

    protected function filter($result)
    {
        $result = json_decode($result);
        if ($result && $this->model == MODEL_SIMPLE && is_array($result) && isset($result[0][0][0])) {
            return $result[0][0][0];
        }

        return $result;
    }

    protected function getQueryUrl()
    {
        $params = array(
            'client' => $this->client,
            'sl' => $this->sl,
            'tl' => $this->tl,
            'hl' => $this->hl,
            'dt' => $this->dt,
            'ie' => $this->ie,
            'oe' => $this->oe,
            'otf' => $this->otf,
            'ssel' => $this->ssel,
            'tsel' => $this->tsel,
            //'kc' => $this->kc,
            'tk' => $this->tk,
            'q' => rawurlencode($this->q),
        );
        $query = $this->buildQuery($params);
        $url = $this->host . $this->path . '?' . $query;
        return $url;
    }

    protected function buildQuery($params, $k = '')
    {
        $query = '';
        if (is_array($params)) {
            foreach ($params as $key => $one) {
                if (is_array($one)) {
                    $query .= '&' . $this->buildQuery($one, $key);
                } else {
                    if ($k) {
                        $key = $k;
                    }
                    $query .= '&' . $key . '=' . $one;

                }
            }
        }
        $query = trim($query, '&');
        return $query;
    }

    protected function getOption()
    {
        if ($this->option) {
            $option = $this->option;
        } else {
            $option = array(
                'User-Agent:Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.86 Safari/537.36'
            );
        }

        return $option;
    }


    protected function cipher($a, $b)
    {
        for ($d = 0; $d < mb_strlen($b, 'UTF-8') - 2; $d += 3) {
            $c = mb_substr($b, $d + 2, 1, 'UTF-8');
            $c = ord('a') <= ord($c) ? ord($c) - 87 : intval($c);
            $c = '+' == mb_substr($b, $d + 1, 1, 'UTF-8') ? Tool::unSignedShiftRightOperator($a,
                $c) : Tool::shiftLeftOperator($a,
                $c);
            $a = '+' == mb_substr($b, $d, 1, 'UTF-8') ? Tool::andOperator($a + $c, 4294967295) : Tool::xorOperator($a,
                $c);

        }
        return $a;

    }

    protected function tk($query, $tkk)
    {
        $a = $query;
        $e = explode('.', $tkk);
        $h = intval($e[0]) ? intval($e[0]) : 0;
        $g = [];
        $d = 0;
        for ($f = 0; $f < mb_strlen($a, 'UTF-8'); $f++) {
            $c = $this->charCodeAt($a, $f);
            if (128 > $c) {
                $g[$d++] = $c;
            } else {
                if (2048 > $c) {
                    $g[$d++] = Tool::orOperator(Tool::shiftRightOperator($c, 6), 192);//$c >> 6 | 192;
                } else {
                    if (55296 == (Tool::andOperator($c, 64512)) && $f + 1 < mb_strlen($a,
                            'UTF-8') && 56320 == Tool::andOperator($this->charCodeAt($a, $f + 1), 64512)
                    ) {
                        $c = 65536 + Tool::shiftLeftOperator(Tool::andOperator($c, 1023),
                                10) + (Tool::andOperator($this->charCodeAt($a, ++$f), 1023));
                        $g[$d++] = Tool::orOperator(Tool::shiftRightOperator($c, 18), 240);//$c >> 18 | 240;
                        $g[$d++] = Tool::orOperator(Tool::andOperator(Tool::shiftRightOperator($c, 12), 63), 128);//
                    } else {
                        $g[$d++] = Tool::orOperator(Tool::shiftRightOperator($c, 12), 224);//$c >> 12 | 224;
                        $g[$d++] = Tool::orOperator(Tool::andOperator(Tool::shiftRightOperator($c, 6), 63),
                            128);//$c >> 6 & 63 | 128;
                    }

                }
                $g[$d++] = Tool::orOperator(Tool::andOperator($c, 63), 128);//$c & 63 | 128;
            }

        }

        $a = $h;
        for ($d = 0; $d < count($g); $d++) {
            $a += $g[$d];
            $a = $this->cipher($a, "+-a^+6");
        }
        $a = $this->cipher($a, "+-3^+b+-f");
        $e[1] = intval($e[1]) ? intval($e[1]) : 0;
        $a = Tool::xorOperator($a, $e[1]);
        //$a ^= intval($e[1]) ? intval($e[1]) : 0;
        if (0 > $a) {
            $a = Tool::andOperator($a, 2147483647) + 2147483648;
        }
        $a %= 1E6;
        return $a . '.' . Tool::xorOperator($a, $h);

    }

    protected function charCodeAt($str, $index)
    {

        $char = mb_substr($str, $index, 1, 'UTF-8');

        if (mb_check_encoding($char, 'UTF-8')) {
            $ret = mb_convert_encoding($char, 'UTF-32BE', 'UTF-8');
            return hexdec(bin2hex($ret));
        } else {
            return null;
        }

    }

    protected function getTkk()
    {
        $response = $this->curlGet($this->host, $this->getOption());

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
        throw new \UnexpectedValueException('can\'t find TKK');
    }

    protected function curlGet($url, $option = array(), $time = 3)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $time);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $option);
        $ret = curl_exec($ch);
        curl_close($ch);
        return $ret;
    }

    public function getLangs()
    {
        $langs = [
            'en' => '英语',
            'auto' => '检测语言',
            'sq' => '阿尔巴尼亚语',
            'ar' => '阿拉伯语',
            'am' => '阿姆哈拉语',
            'az' => '阿塞拜疆语',
            'ga' => '爱尔兰语',
            'et' => '爱沙尼亚语',
            'eu' => '巴斯克语',
            'be' => '白俄罗斯语',
            'bg' => '保加利亚语',
            'is' => '冰岛语',
            'pl' => '波兰语',
            'bs' => '波斯尼亚语',
            'fa' => '波斯语',
            'af' => '布尔语(南非荷兰语)',
            'da' => '丹麦语',
            'de' => '德语',
            'ru' => '俄语',
            'fr' => '法语',
            'tl' => '菲律宾语',
            'fi' => '芬兰语',
            'fy' => '弗里西语',
            'km' => '高棉语',
            'ka' => '格鲁吉亚语',
            'gu' => '古吉拉特语',
            'kk' => '哈萨克语',
            'ht' => '海地克里奥尔语',
            'ko' => '韩语',
            'ha' => '豪萨语',
            'nl' => '荷兰语',
            'ky' => '吉尔吉斯语',
            'gl' => '加利西亚语',
            'ca' => '加泰罗尼亚语',
            'cs' => '捷克语',
            'kn' => '卡纳达语',
            'co' => '科西嘉语',
            'hr' => '克罗地亚语',
            'ku' => '库尔德语',
            'la' => '拉丁语',
            'lv' => '拉脱维亚语',
            'lo' => '老挝语',
            'lt' => '立陶宛语',
            'lb' => '卢森堡语',
            'ro' => '罗马尼亚语',
            'mg' => '马尔加什语',
            'mt' => '马耳他语',
            'mr' => '马拉地语',
            'ml' => '马拉雅拉姆语',
            'ms' => '马来语',
            'mk' => '马其顿语',
            'mi' => '毛利语',
            'mn' => '蒙古语',
            'bn' => '孟加拉语',
            'my' => '缅甸语',
            'hmn' => '苗语',
            'xh' => '南非科萨语',
            'zu' => '南非祖鲁语',
            'ne' => '尼泊尔语',
            'no' => '挪威语',
            'pa' => '旁遮普语',
            'pt' => '葡萄牙语',
            'ps' => '普什图语',
            'ny' => '齐切瓦语',
            'ja' => '日语',
            'sv' => '瑞典语',
            'sm' => '萨摩亚语',
            'sr' => '塞尔维亚语',
            'st' => '塞索托语',
            'si' => '僧伽罗语',
            'eo' => '世界语',
            'sk' => '斯洛伐克语',
            'sl' => '斯洛文尼亚语',
            'sw' => '斯瓦希里语',
            'gd' => '苏格兰盖尔语',
            'ceb' => '宿务语',
            'so' => '索马里语',
            'tg' => '塔吉克语',
            'te' => '泰卢固语',
            'ta' => '泰米尔语',
            'th' => '泰语',
            'tr' => '土耳其语',
            'cy' => '威尔士语',
            'ur' => '乌尔都语',
            'uk' => '乌克兰语',
            'uz' => '乌兹别克语',
            'es' => '西班牙语',
            'iw' => '希伯来语',
            'el' => '希腊语',
            'haw' => '夏威夷语',
            'sd' => '信德语',
            'hu' => '匈牙利语',
            'sn' => '修纳语',
            'hy' => '亚美尼亚语',
            'ig' => '伊博语',
            'it' => '意大利语',
            'yi' => '意第绪语',
            'hi' => '印地语',
            'su' => '印尼巽他语',
            'id' => '印尼语',
            'jw' => '印尼爪哇语',
            'en' => '英语',
            'yo' => '约鲁巴语',
            'vi' => '越南语',
            'zh-CN' => '中文',
        ];

        return $langs;
    }


}