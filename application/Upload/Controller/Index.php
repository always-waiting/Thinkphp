<?php
/**
 * Created by PhpStorm.
 * User: mixichao
 * Date: 2017/9/21
 * Time: 21:45
 */

namespace app\Upload\Controller;


class Index
{
    public function upload() {
        //return "tessst";
        $file = request()->file("image");
        if ($file) {
            $info = $file->move(ROOT_PATH."public".DS."uploads");
            if ($info) {
                echo $info->getExtension();
                echo $info->getSaveName();
                echo $info->getFilename();
            } else {
                echo $file->getError();
            }
        }
    }
}