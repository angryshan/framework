<?php
namespace config\lib;

class log{
    static $class;//用于存储类

    /**
     * 确定日志存储方式
     * @throws \Exception
     */
    static public function init(){
        $drive = conf::get('log','config');#加载单个配置文件驱动名（file）
        $class = '\config\lib\drive\log\\'.$drive['DRIVE'];
        self::$class = new $class;
    }

    /**
     * 开始写日志
     * @param $name string 日志名称
     * @param string $file 文件后缀
     */
    static public function log($name,$file='log'){
        self::$class->log($name,$file);
    }
}