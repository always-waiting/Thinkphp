<?php
/**
 * Created by PhpStorm.
 * User: mixichao
 * Date: 2017/9/19
 * Time: 17:07
 */

namespace app\Request\controller;


class F1
{
    protected $name;
    public function __construct($name = null)
    {
        $this->name = $name;
    }
    public function show()
    {
        //return "fun";
        return "name: " . $this->name;
    }
}