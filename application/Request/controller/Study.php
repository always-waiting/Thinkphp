<?php
/**
 * Created by PhpStorm.
 * User: mixichao
 * Date: 2017/9/19
 * Time: 15:53
 */

namespace app\Request\controller;

use think\Request;
// 用RESTful来绑定http://localhost/request/路由

class Study
{
    public function index()
    {
        $request = Request::instance();
        // 获取当前域名
        echo 'domain: ' . $request->domain() . '<br/>';
        // 获取当前入口文件
        echo 'file: ' . $request->baseFile() . '<br/>';
        // 获取当前URL地址 不含域名
        echo 'url: ' . $request->url() . '<br/>';
        // 获取包含域名的完整URL地址
        echo 'url with domain: ' . $request->url(true) . '<br/>';
        // 获取当前URL地址 不含QUERY_STRING
        echo 'url without query: ' . $request->baseUrl() . '<br/>';
        // 获取URL访问的ROOT地址
        echo 'root:' . $request->root() . '<br/>';
        // 获取URL访问的ROOT地址
        echo 'root with domain: ' . $request->root(true) . '<br/>';
        // 获取URL地址中的PATH_INFO信息
        echo 'pathinfo: ' . $request->pathinfo() . '<br/>';
        // 获取URL地址中的PATH_INFO信息 不含后缀
        echo 'pathinfo: ' . $request->path() . '<br/>';
        // 获取URL地址中的后缀信息
        echo 'ext: ' . $request->ext() . '<br/>';
        echo "当前模块名称是" . $request->module(),'<br>';
        echo "当前控制器名称是" . $request->controller(),'<br>';
        echo "当前操作名称是" . $request->action(),'<br>';
        echo '请求方法：' . $request->method() . '<br/>';
        echo '资源类型：' . $request->type() . '<br/>';
        echo '访问ip地址：' . $request->ip() . '<br/>';
        echo '是否AJax请求：' . var_export($request->isAjax(), true) . '<br/>';
        echo '请求参数：';
        dump($request->param());
        echo '请求参数：仅包含name';
        dump($request->only(['name']));
        echo '请求参数：排除name';
        dump($request->except(['name']));
        echo '路由信息：';
        dump($request->route());
        echo '调度信息：';
        dump($request->dispatch());
        echo 'SERVER变量';
        dump($request->server());
        return "get http://localhost/request";
    }
    public function read($id)
    {
        Request::hook('user_read','app\Request\controller\getUserInfo');
        $request = Request::instance();
        dump($request->param());
        echo 'pathinfo: ' . $request->pathinfo() . '<br/>';
        // 获取URL地址中的PATH_INFO信息 不含后缀
        echo 'pathinfo: ' . $request->path() . '<br/>';
        dump($request->route());
        return Request::instance()->user_read($id);
    }
    public function create()
    {
        Request::instance()->attributeinsert = 1234;
        return Request::instance()->attributeinsert;
    }
}

function getUserInfo(Request $request, $id)
{
    return "这是一个方法注入的例子： " . $id;
}