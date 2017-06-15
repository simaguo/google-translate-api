<?php

/**
 * Created by PhpStorm.
 * User: lyolz
 * Date: 2017/6/15
 * Time: 19:23
 */
class Javascript
{

    public function toInt32($a,$os=32)
    {
        $a=(int) $a;
        $bin = $this->binary($a);
        $len = strlen($bin);
        if($a>=0){
            if($len>=$os){
                return substr($bin,0-$os);
            }else{
                return str_pad($bin,$os,0,STR_PAD_LEFT);
            }
        }else{
            if($len > $os-1){
                return substr($bin,0-$os);
            }else{
                return '1'.str_pad($bin,$os-1,0,STR_PAD_LEFT);
            }
        }

    }


    /**
     * 获取数字绝对值的二进制码
     * @param $a
     * @return string
     */
    public function binary($a){
        $a=abs($a);
        $c=[];
        do{
            $c[]=$a%2;
            $a=floor($a/2);
        }while($a);

        return implode('' , array_reverse($c));
    }

    public function test()
    {
        echo $this->getTureCode(-128,32);
        //echo $this->getTureCode(-127,8);
    }
}

$j=new Javascript();
$j->test();