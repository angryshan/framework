<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/4 0004
 * Time: 下午 2:13
 */
namespace config\lib;
use config\lib\conf;
class route{
    public $route;
    public $ctrl;#控制器
    public $action;#方法

    public function __construct()
    {
        $this->route = conf::get('route','config');

        /**
         * 1.隐藏index.php文件，如上所示
         * 2.获取URL 参数部分
         * 3.返回对应控制器和方法
         */
        if (isset($_SERVER['REQUEST_URI'])&& $_SERVER['REQUEST_URI'] != '/'){
            $path = $_SERVER['REQUEST_URI'];
            $pathArr = explode('/',trim($path,'/'));

            if (isset($pathArr[0])){
                $this->ctrl = $pathArr[0];
                unset($pathArr[0]);
            }
            if (isset($pathArr[1])){
                $this->action = $pathArr[1];
                unset($pathArr[1]);
            }else{
                $this->action = $this->route['ACTION'];
            }
            //url 多余部分转换成GET eg:index/index/id/1 只留下id 实现get传值
            $count = count($pathArr) + 2;
            $i = 2;
            while ($i < $count){
                if (isset($pathArr[$i+1])){
                    $_GET[$pathArr[$i]] = $pathArr[$i+1];
                }
                $i = $i + 2;
            };


        }else{
            $this->ctrl = $this->route['CTRL'];
            $this->action = $this->route['ACTION'];
        }
    }
}