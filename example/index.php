<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/17
 * Time: 10:25
 */

require __DIR__ . '/../vendor/autoload.php';

$client = new Simaguo\GoogleTranslateApi\Client('package',LANG_EN,LANG_CN);

echo $client->translate();
echo "\n";

$t = $client->from(LANG_CN)->to(LANG_EN)->hl(LANG_EN)->translate('20年来，有一项活动驻港部队每年举办、从未停止，成为香港市民了解驻军的一扇窗口，也成为增进军民情谊的桥梁和纽带。');

print_r($t);
echo "\n";