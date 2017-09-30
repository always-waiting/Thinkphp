<?php
/**
 * Created by PhpStorm.
 * User: mixichao
 * Date: 2017/9/19
 * Time: 9:00
 */

namespace app\Config\controller;


class ConfigTest
{
    public function dump()
    {
        //dump(\think\Config::get());
        return xml(\think\Config::get());
        //return \think\config();
        //return "testing";
    }
}