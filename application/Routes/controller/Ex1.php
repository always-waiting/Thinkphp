<?php
/**
 * Created by PhpStorm.
 * User: mixichao
 * Date: 2017/9/19
 * Time: 11:50
 */

namespace app\Routes\controller;


class Ex1
{
    public function get($name,$id)
    {
        return __FILE__ . "Say: " . $name . " " . $id   ;
    }
}