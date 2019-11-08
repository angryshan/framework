<?php
namespace config;

use config\lib\conf;

class loader {
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
            $file = APP_PATH.'/'.$class.'.php';

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
        $ctrlFile = APP.'/'.$route->path.'/controller/'.$ctrlClass.'.php';#控制器文件
        $ctrlClass1 = '\\'.MODULE.'\controller\\'.$ctrlClass;
        if (is_file($ctrlFile)){
            $warning = conf::get('warning','config');
            if ($warning){
                error_reporting( E_ALL&~E_NOTICE );//不看警告信息
            }
            $debug = conf::get('debug','config');
            ini_set('display_errors',$debug);

            include $ctrlFile;
            $ctrl = new $ctrlClass1();
            $data = $ctrl->$action();
            if ($data){
                echo json_encode($data);
            }else{
                echo $data;
            }

            \config\lib\log::log('ctrl:'.$ctrlClass.'  '.'action:'.$action);//写日志
        }else{
//            throw new \Exception('找不到控制器'.$ctrlClass);
            var_dump('找不到控制器'.$ctrlClass);
        }
    }


}