<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;
Route::rule("new/:id","index/News/read");
Route::get('item<name><id>','Routes/Ex1/get',[],['name'=>'[a-zA-Z]+','id'=>'\d+']);
Route::resource('blog','index/blog',['var'=>['blog'=>'blog_id']]);
Route::controller('user','index/User');

Route::get('hello$',function(){
    return 'hello,world!';
});

Route::get('hello1/:name',function($name){
    return 'Hello,'.$name;
});

Route::get('beijing','index/beijing/show');

// 定义request学习资源
Route::resource("request",'request/Study');
Route::get("request/good","request/F1/show");

// 学习数据库
// 同时完成套餐-类型判断工作
Route::resource('SN','database/index');

// 学习视图
Route::get("Views","Views/ViewStudy/f1");

// 学习验证器
Route::get("validation","Validation/ValidateStudy/f1");

// 学习文件上传
Route::any("upload","Upload/index/upload");
return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],
    //"__miss__" => 'error/miss',

];
