<?php
/**
 * Created by PhpStorm.
 * User: mixichao
 * Date: 2017/9/21
 * Time: 17:26
 */

namespace app\Validation\Controller;

use \think\Validate;
use \think\Cache;
use \think\Cookie;
use \think\Controller;
use \app\Database\model\HardDevicesInfo;
class ValidateStudy extends Controller
{
    public function f1() {
        /**
         * example 1
        $validate = new Validate([
           'name' => 'require|max:25',
            'email' => 'email',
        ]);
        $data = [
            //'name' => 'thinkphp',
            'email' => 'thinkphp@qq.com',
        ];
        if (!$validate->check($data)) {
            dump($validate->getError());
            return "Baaaad";
        } else {
            return "Gooood";
        }
         */
        /**
         * example 2
         *
        $rule = [
            'name'  => 'require|max:25',
            'age'   => 'number|between:1,120',
            'email' => 'email',
        ];

        $data = [
            'name'  => 'thinkphp',
            //'age|年龄'   => 121,
            'age'   => 121,
            'email' => 'thinkphp@qq.com',
        ];
        $msg = [
            'name.require' => '名称必须',
            'name.max'     => '名称最多不能超过25个字符',
            'age.number'   => '年龄必须是数字',
            'age.between'  => '年龄必须在1~120之间',
            'email'        => '邮箱格式错误',
        ];
        $validate = new Validate($rule, $msg);
        $result   = $validate->check($data);
        if(!$result){
            echo $validate->getError();
        }
         */
        /**
        $options = [
            // 缓存类型为File
            'type'  =>  'File',
            // 缓存有效期为永久有效
            'expire'=>  0,
            //缓存前缀
            'prefix'=>  'think',
            // 指定缓存目录
            'path'  =>  APP_PATH.'runtime/cache/',
        ];
        Cache::connect($options);
        $value = "bixichao";
        Cache::set('name',$value,3600);
        dump(Cache::get('name'));
         */
        /**
        Cookie::init(['prefix'=>'think_','expire'=>3600,'path'=>'/']);
        Cookie::set('name', $value);
         */
        /**
         * 设置分页功能
         *
        $list = HardDevicesInfo::where('Physical_Hard_size',"300GB")->paginate(10);
        $page = $list->render();
        $this->assign('list', $list);
        $this->assign('page', $page);
        return $this->fetch();
         */
        //return "fuuuun";
    }
}