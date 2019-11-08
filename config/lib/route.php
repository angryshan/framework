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
    public $path = '';#方法

    public function __construct()
    {
        $this->route = conf::get('route','config');

        /**
         * 1.隐藏index.php文件，如上所示
         * 2.获取URL 参数部分
         * 3.返回对应控制器和方法
         */
        if (isset($_SERVER['REQUEST_URI'])&& $_SERVER['REQUEST_URI'] != '/'){
            $url = $_SERVER['REQUEST_URI'];
            $pathArr = explode('/',trim($url,'/'));//去掉左右两边的/，分成数组

            //控制层
            if (isset($pathArr[0])){
                if (strpos($pathArr[0],'.')){//控制器中是否存在点（判断是第几层控制层）
                    $paths = explode('.',trim($pathArr[0],'.'));
                    $count = count($paths);
                    $pathArr[0] = $paths[$count-1];
                    unset($paths[$count-1]);
                    $this->path = implode('/',$paths);
                }

                $this->ctrl = $pathArr[0];
                unset($pathArr[0]);
            }
            //方法层
            if (isset($pathArr[1])){
                $this->action = $pathArr[1];
                unset($pathArr[1]);
            }else{
                $this->action = $this->route['ACTION'];
            }

            //是否自己重定向路由
            if ($this->route['isOpenRoute']){
                $route = conf::get('route','route');
                if (isset($route[$this->ctrl])){
                    if($route[$this->ctrl] instanceof \Closure){

                        $route[$this->ctrl]();

                    } else{
                        $arr=explode('@', $route[$this->ctrl]);
                        $this->ctrl = $arr[0];
                        $this->action = $arr[1];
                    }
                }
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