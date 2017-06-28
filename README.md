调用谷歌翻译服务，英译汉

安装
---
    composer require simaguo/google-translate-api

使用案例
----

    <?php
        require __DIR__ . '/../vendor/autoload.php';

        $client = new Simaguo\GoogleTranslateApi\Client('package',LANG_EN,LANG_CN);

        echo $client->translate();
        echo "\n";

        $t = $client->from(LANG_CN)->to(LANG_AF)->hl(LANG_AF)->translate('老师');

        print_r($t);
        echo "\n";




返回结果

    包
    onderwyser