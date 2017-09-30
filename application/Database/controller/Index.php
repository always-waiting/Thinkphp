<?php
/**
 * Created by PhpStorm.
 * User: mixichao
 * Date: 2017/9/19
 * Time: 17:38
 */

namespace app\Database\controller;

use think\Db;
use app\Database\model\HardDevicesInfo;
use app\Database\model\MEMException;
use app\Database\model\CPUException;
use think\exception\ErrorException;

class Index
{
    public function index()
    {
        //默认查询id = 13747
        // 用query查询一个数据
        //dump(Db::query('select * from hard_devices_info where id=13747'));
        // 用table相同实现
        //dump(Db::table("hard_devices_info")->where('id',13747)->find());
        //dump(Db::table("hard_devices_info")->where('id',13747)->select());
        // 用chunk函数完成全部处理
        /**
        Db::table("hard_devices_info")->chunk(100,function($computes) {
            foreach ($computes as $compute)
            {
                echo $compute['id'],"<br>";
            }
        });
         *
        Db::table("hard_devices_info")->chunk(100,function($computes){
            foreach ($computes as $compute)
            {
                //echo $compute['id'], "\t======>\t", $compute['Device_SN'],"\t=======>\t",$compute['Physical_Cpu_Model'],"
                //\t======\t",$compute['Physical_Hard_size'],"<br>";
                //echo $compute["Physical_Memory_Sizes"],"<br>";
                echo $compute['Physical_Hard_size'],"<br>";
            }
        });
         */
        /**
        $compute = HardDevicesInfo::get(['Device_SN' => 'BBPT7C2']);
        //echo $compute->cpu_trim(),"<br>";
        //dump($compute);
        echo $compute->match_pipeline();
        */
        /**
         * 测试preg_split
         *
        $str = "182GB";
        $arr = preg_split("/GB|\s|MB|TB/",$str,-1,PREG_SPLIT_NO_EMPTY);
        dump($arr);
         */
        /**
         * 测试在函数中应用外部变量
         */
        //$filename = __DIR__ . "\\123.txt";
        //$file = fopen($filename,"r");
        //echo fread($file, filesize($filename));
        /**
         * 匿名函数
         *
        $a = function() {
            echo "b";
        };
        $a();
         */
        //fclose($file);
        /**
         * 测试键值不存在情况
        $a = array("a" => 1,"b"=>2);
        echo $a["c"],"<br>";
        */
        /**
         * 测试传递引用
         *
        $a = array(1,2,3,4);
        $b= function(&$x,$y=1) {
            $x[0] = 10;
            var_dump($x);
            echo $y,"<br>";
            return $x;
        };
        $c = $b($a,5);
        $c[0] = 100;
        var_dump($a);
        var_dump($c);
         */
        /**
         * 找数据bug
         */
        //$compute=HardDevicesInfo::get(['id'=>238818]);//精确匹配，且有2个结果
        //$compute=HardDevicesInfo::get(['id'=>238361]);//模糊匹配
       // $compute=HardDevicesInfo::get(['id'=>122240]);
        $compute=HardDevicesInfo::get(['id'=>299876]);
        echo $compute->Device_SN,"<br>";
        //echo $compute->Physical_Memory_Sizes,"<br>";
        $fun='memory_trim';
        echo $compute->cpu_trim(),"<br>";
        echo $compute->$fun(),"<br>";
        echo $compute->getAttr('Physical_Hard_Number'),"<br>";
        echo $compute->total_hard_sizes(),'<br>';
        echo $compute->match_pipeline(2,'text',"tree_method"),"<br>";
        echo $compute->match_pipeline(2,'text',"distance_method");
        /**
         * 测试array_walk
         *
        $a = [
          [1,2,3],
          ['a','b','c']
        ];
        $b = [];
        $c = ['a'=>1];
        array_walk($a, function($item, $key) use (&$b){
            echo $key,"<br>";
            $b[] =  $item[1];
        });
        var_dump($b);
        echo array_key_exists('a',$c);
         */
        /**
         * 内存优化处理
         *
        $a = 100;
        $str = decbin($a);
        echo $a,"<br>";
        echo $str,"<br>";
        $str_new = "1".str_replace("1","0",$str);
        echo $str_new,"<br>";
        echo bindec($str_new);
         */
        return "<br>last line good";
    }
    public function _empty()
    {
        /**
        $a = "32xIntel(R)Xeon(R)CPUE5-2640v3@2.60GHz";
        if (strpos($a,"Intel")) {
            echo "Intel","<br>";
            $fun = strstr($a,"CPU");
            echo $fun,'<br>';
            echo strpos($fun,"@"),"<br>";
            echo substr($fun,3,strpos($fun,"@")-3),"<br>";
        } else {
            echo "AMD";
        }
         */
        /**
        $c=array();
        $c[]=1;
        $c[]=2;
        if (in_array(1,$c)) {
            echo "Find","<br>";
        } else {
            echo "Not Find<br>";

        }
         */
        /**
         * $b = preg_split("/[,\s]/",$a);
         *$b[] = 1;
         *$b[] = 2;
         *dump($b);
         *$a = "1xAMDOpteron(TM)Processor6220";
         *$trim_c = substr(strstr($a,"Processor"),strlen("Processor"));
         *echo $trim_c;
         */
        /**
         $a = array(2,1,3);
         sort($a);
         echo join(",",$a);
         */
        /**
        $a = array("",1);
        echo join(",", $a);
         */
        /**
        $sn = "CRHY252";
        $id = 15097;
        $compute = HardDevicesInfo::get(['id' => $id]);
        echo $compute->dict_has_cpu(),"<br>";
        echo $compute->dict_has_memory(),"<br>";
        echo $compute->total_hard_sizes(),"<br>";
        //var_dump($compute->match());
        //echo $compute->match_pipeline(),"<br>";
        //echo $compute->Device_SN,"<br>";
        */
        /**
         * 测试hard_normal性质，分MB,GB,TB
         *
        $test_MB_arr = array(
            1144641, 114473, 1526185, 1907729, 286102, 286168, 3815447, 457862, 5723166, 572325, 763097
        );
        $test_GB_arr = array(
            111.79, 136.731, 146, 149.049, 279.396, 279.460, 300, 4000.7, 476.939, 559.911, 600, 72, 745.211, 800, 894.252, 931.512,
        );
        $test_TB_arr = array(
            1.090, 1.455, 1.819, 1, 2, 5.458, 3.638,
        );
        echo "<html><body>";
        echo "<h1>测试MB结果</h1>";
        foreach ($test_MB_arr as $mb) {
            echo $mb, " =====> ", $compute->hard_normal($mb),"<br>";
        }
        echo "<h1>测试GB结果</h1>";
        foreach ($test_GB_arr as $gb) {
            echo $gb, " =====> ", $compute->hard_normal($gb), "<br>";
        }
        echo "<h1>测试TB结果</h1>";
        foreach ($test_TB_arr as $tb) {
            echo $tb, " =====> ", $compute->hard_normal(($tb)),"<br>";
        }
        echo "<h1>测试0输入</h1>";
        try {
            $compute->hard_normal(0);
        } catch (\Exception $e){
            echo $e->getMessage(),"<br>";
        }
        echo "</body></html>";
         */
        /**
        $string = "123MB";
        echo preg_match('/^\d+GB$/',$string);
        dump(HardDevicesInfo::$combo_type_hash["E5-2683v4"][256]);
         */
        /**
        $a = array(
            "a" => 1,
            "b" => 2,
        );
        echo array_key_exists("d",$a);
         */
        /**
         * 测试所有数据
         *
        HardDevicesInfo::chunk(100, function($computes) {
            foreach ($computes as $compute) {
                echo "<h1>", $compute->id, "----", $compute->Device_SN, "</h1>";
                echo $compute->match_pipeline(), "<br>";
            }
        });
        */
        /**
         * 把结果写入一个txt文件中，以tab分隔
         */
        //echo __DIR__,"<br>";
        $file = fopen(__DIR__ . "\\123.txt","w") or die("Unable open 123.txt");
        //echo nl2br(fread($myfile,filesize("123.txt")));

        $check = function($computes) use ($file) {
            foreach ($computes as $compute) {
                $txt = $compute->id ."\t". nl2br($compute->Device_SN)."\t";
                try {
                    $memory = $compute->memory_trim();
                } catch (MEMException $e) {
                    $memory = $e->getMessage();
                }
                try {
                    $cpu = $compute->cpu_trim();
                }catch (CPUException $e) {
                    $cpu = $e->getMessage();
                }
                $config = $cpu."/".$memory."/".$compute->getAttr('Physical_Hard_Number').'/'.$compute->total_hard_sizes();
                $result = $compute->match_pipeline(2,'text', 'distance_method');
                $txt .= $config."\t".$result . "\n";
                fwrite($file, $txt);
            }
        };
        \think\Debug::remark("begin");
        HardDevicesInfo::chunk(100, $check);
        \think\Debug::remark('end');
        echo \think\Debug::getRangeTime('begin','end').'s',"<br>";
        echo \think\Debug::getRangeMem('begin','end').'kb',"<br>";
        fclose($file);
        //*/
        /**
         * array_unique
         *
        $a = array(1,1,1,2);
        var_dump(array_unique($a));
         */
        /**
         * 测试新的精确匹配
         *
        $sn = "6CU530XTJH";
        $compute = HardDevicesInfo::get(['Device_SN' => $sn]);
        echo $compute->cpu_trim(),"<br>";
        echo $compute->memory_trim(),"<br>";
        echo $compute->getAttr("Physical_Hard_Number"),"<br>";
        echo $compute->total_hard_sizes(),"<br>";
        //var_dump($compute->match());
        //echo $compute->match_pipeline();
        // 测试模糊匹配
        //var_dump( $compute->match_with_vote(3));
        echo $compute->match_pipeline();
        */
        /**
         * 测试自动++
         *
        $a = array();
        $a[1]++;
         */
        return "没有定义相应的方法";
    }
}