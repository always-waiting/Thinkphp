<?php
/**
 * Created by PhpStorm.
 * User: mixichao
 * Date: 2017/9/19
 * Time: 9:51
 */

namespace app\Env\controller;


class EnvTest
{
    public function dump()
    {
        echo "good1<br>";
        echo \think\Env::get("envfun"),"<br>";
        return 1;
        //return "good";
    }
}