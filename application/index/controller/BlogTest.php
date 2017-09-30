<?php
/**
 * Created by PhpStorm.
 * User: mixichao
 * Date: 2017/9/18
 * Time: 22:28
 */

namespace app\index\controller;


class BlogTest
{
    public function Fun()
    {
        return "This is " . __FILE__;
    }
    public function blogjson()
    {
        $data = ['name'=>'thinkphp','url'=>'thinkphp.cn'];
        // 指定json数据输出
        return json(['data'=>$data,'code'=>1,'message'=>'操作完成']);
    }
}