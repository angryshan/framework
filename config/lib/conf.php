<?php
namespace config\lib;
class conf{
    static public $conf = array();#存放配置名，节省资源
    static public $path ;#存放配置名，节省资源

    public function __construct()
    {
        self::$path = APP_PATH.'/config/config/';
    }

    /**
     * 加载单个配置名 返回配置名称
     * 常用，因此定义为静态
     * @param $name string 配置项名称
     * @param $file string 配置文件
     * @return mixed
     * @throws \Exception
     */
    static public function get($name,$file){
        if (isset(self::$conf[$file])){//若文件存在，直接加载，避免重复资源
            return self::$conf[$file][$name];
        }else{
            $path = APP_PATH.'/config/config/'.$file.'.php';//config里的配置文件
            if (is_file($path)){
                $conf = include $path;
                if (isset($conf[$name])){
                    self::$conf[$file] = $conf;
                    return $conf[$name];
                }else{
                    throw new \Exception('没有这个配置名'.$name);
                }
            }else{
                throw new \Exception('没有这个配置文件'.$file);
            }
        }
    }

    /**
     * 引入文件的全部配置名
     * @param $file
     * @return mixed
     * @throws \Exception
     */
    static public function all($file){
        if (isset(self::$conf[$file])){
            return self::$conf[$file];
        }else{
            $path = APP_PATH.'/config/config/'.$file.'.php';
            if (is_file($path)){
                $conf = include $path;
                self::$conf[$file] = $conf;
                return $conf;
            }else{
                throw new \Exception('找不到该配置文件'.$file);
            }
        }
    }
}