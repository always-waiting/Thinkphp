<?php
/**
 * Created by PhpStorm.
 * User: mixichao
 * Date: 2017/9/19
 * Time: 10:18
 */

namespace app\index\controller;

use think\Exception;

function exceptions_error_handler($severity, $message, $filename, $lineno) {
    if (error_reporting() == 0) {
        return;
    }
    if (error_reporting() & $severity) {
        throw new \ErrorException($message, 0, $severity, $filename, $lineno);
    }
}

set_error_handler('app\index\controller\exceptions_error_handler');

class News
{
    /**
     * @return string
     */
    public function read($id)
    {
        //$id = $_GET["id"];
        //return "Hello man, " . $id;
        //$id = 100;
        //echo $id,"<br>";
        //echo $HTTP_GET_VARS["name"],"<br>";

        // solution 1: $name = @ $_GET["name"];
        /** solution 2;
        *if (isset($_GET["name"])) {
        *    $name = $_GET["name"];
        *} else {
        *    $name = "";
        *}
        */
        /** solution 3:
        try {
            $name = $_GET["name"];
        } catch (\Exception $e) {
            echo $e->getMessage(), "<br>";
            $name = "";
        }
         */
        $name = "";
        if ($name)
        {
            echo $name,"<br>";
        }
        return "Hello route: new/:id ===> new/" . $id;
    }

}