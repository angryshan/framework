<?php
namespace config;

use config\lib\conf;

class lss {
    #用于判断类是否存在，节约性能
    public static $classMap = array();

    /**
     * 自动加载类
     * @param $class
     * @return bool
     */
    static public function load($class){
        if (isset($classMap[$class])){
            return true;
        }else{
            $class = str_replace('\\','/',$class);
            $file = LSS.'/'.$class.'.php';

            if (is_file($file)){
                include $file;
                self::$classMap[$class] = $class;
            }else{
                return false;
            }
        }
    }

    /**
     * 运行控制器和方法
     * @throws \Exception
     */
    static public function run(){
        \config\lib\log::init();//确定日志存储方式

        $route =new \config\lib\route();
        $ctrlClass = $route->ctrl;
        $action = $route->action;
        $ctrlFile = APP.'/controller/'.$ctrlClass.'.php';#控制器文件
        $ctrlClass1 = '\\'.MODULE.'\controller\\'.$ctrlClass;
        if (is_file($ctrlFile)){
            include $ctrlFile;
            $ctrl = new $ctrlClass1();
            echo $ctrl->$action();
            \config\lib\log::log('ctrl:'.$ctrlClass.'  '.'action:'.$action);//写日志
        }else{
            throw new \Exception('找不到控制器'.$ctrlClass);
        }
    }

}