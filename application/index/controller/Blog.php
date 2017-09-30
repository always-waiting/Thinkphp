<?php
/**
 * Created by PhpStorm.
 * User: mixichao
 * Date: 2017/9/19
 * Time: 13:53
 */

namespace app\index\controller;


class Blog
{
    public function index()
    {
        return "RESTful route: http://servername/blog";
    }
    public function read($blog_id)
    {
        return "RESTful route: http://servername/blog/:blog_id ===> " . __FILE__ . " " . $blog_id;
    }
}