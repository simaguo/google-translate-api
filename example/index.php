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

$t = $client->from(LANG_CN)->to(LANG_AF)->hl(LANG_AF)->translate('老师',MODEL_ALL);

print_r($t);
echo "\n";