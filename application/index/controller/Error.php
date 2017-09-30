<?php
/**
 * Created by PhpStorm.
 * User: mixichao
 * Date: 2017/9/19
 * Time: 14:32
 */

namespace app\index\controller;

use think\Request;

class Error
{
    public function miss()
    {
        return __FILE__ . ": 全局MISS路由";
    }
    public function index(Request $request)
    {
        //根据当前控制器名来判断要执行那个城市的操作
        $cityName = $request->controller();
        return $this->city($cityName);
    }
    protected function city($name)
    {
        //和$name这个城市相关的处理
        return '当前城市' . $name;
    }
    public function _empty(Request $request)
    {
        $cityName = $request->controller();
        return "空操作 " . $this->city($cityName);
    }
}