调用谷歌翻译服务

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

        $t = $client->from(LANG_CN)->to(LANG_AF)->hl(LANG_AF)->translate('老师',MODEL_ALL);

        print_r($t);
        echo "\n";




返回结果

    包
    Array
    (
        [0] => Array
            (
                [0] => Array
                    (
                        [0] => onderwyser
                        [1] => 老师
                        [2] =>
                        [3] =>
                        [4] => 0
                    )

                [1] => Array
                    (
                        [0] =>
                        [1] =>
                        [2] =>
                        [3] => Lǎoshī
                    )

            )

        [1] =>
        [2] => zh-CN
        [3] =>
        [4] =>
        [5] => Array
            (
                [0] => Array
                    (
                        [0] => 老师
                        [1] =>
                        [2] => Array
                            (
                                [0] => Array
                                    (
                                        [0] => onderwyser
                                        [1] => 958
                                        [2] => 1
                                        [3] =>
                                    )

                                [1] => Array
                                    (
                                        [0] => leraar
                                        [1] => 0
                                        [2] => 1
                                        [3] =>
                                    )

                                [2] => Array
                                    (
                                        [0] => n onderwyser
                                        [1] => 0
                                        [2] => 1
                                        [3] =>
                                    )

                            )

                        [3] => Array
                            (
                                [0] => Array
                                    (
                                        [0] => 0
                                        [1] => 2
                                    )

                            )

                        [4] => 老师
                        [5] => 0
                        [6] => 1
                    )

            )

        [6] => 1
        [7] =>
        [8] => Array
            (
                [0] => Array
                    (
                        [0] => zh-CN
                    )

                [1] =>
                [2] => Array
                    (
                        [0] => 1
                    )

                [3] => Array
                    (
                        [0] => zh-CN
                    )

            )

        [9] =>
        [10] =>
        [11] =>
        [12] =>
        [13] =>
        [14] => Array
            (
                [0] => Array
                    (
                        [0] => 老
                        [1] => 师
                        [2] => 我是老师。
                    )

            )

    )
