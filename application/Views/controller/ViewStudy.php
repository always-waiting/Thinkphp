<?php
/**
 * Created by PhpStorm.
 * User: mixichao
 * Date: 2017/9/21
 * Time: 15:10
 */

namespace app\Views\controller;
use \think\Controller;

class ViewStudy extends \think\Controller
{
    public function f1() {
        //return "goood";
        return $this->fetch("hello", ['name' => "thinkphp"]);
    }
}