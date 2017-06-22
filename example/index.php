<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/17
 * Time: 10:25
 */

require __DIR__ . '/../src/Client.php';
$client = new \GoogleTranslateApi\Client();

echo $client->translate('navigate');