<?php
namespace config\lib\dataStructure;
class structureTest{
    protected $class;

    public function __construct(){

    }

    public function index(){
//        性能测试
        $a = array();
        for ($i=0;$i<1000;$i++){
            $a[] = mt_rand(0,1000);
        }

        $msectime1 = $this->get_msectime();
//        $re = $this->bubbling_sort($a);
        $msectime2 = $this->get_msectime();
        echo '冒泡排序时间：'.($msectime2 - $msectime1)."ms<br />";
    }

    public function get_msectime(){
        list($msec, $sec) = explode(' ', microtime());
        $msectime = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
        return $msectime;
    }
}