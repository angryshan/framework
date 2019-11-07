<?php
namespace app\controller;
use config\lib\controller;
use \config\lib\drive\mysql\Mysql;
use config\lib\Env;

class index extends controller {
    //登陆页面
    public function index(){
        $title = '快来聊天';
        $this->assign('title',$title);
        $this->display('index');
    }

    //渲染主页面
    public function home(){
        $this->assign('name',isset($_SESSION['name'])?$_SESSION['name']:'111');
        $this->assign('img',isset($_SESSION['img'])?$_SESSION['img']:'333');
        $this->assign('id',isset($_SESSION['id'])?$_SESSION['id']:'333');
        $this->display('home');
    }

    public function test(){
        if (is_file(ROOT_PATH . '.env')) {
            $env = parse_ini_file(ROOT_PATH . '.env', true);
            foreach ($env as $key => $val) {
                $name = ENV_PREFIX . strtoupper($key);
var_dump($val);
                if (is_array($val)) {
                    foreach ($val as $k => $v) {
                        $item = $name . '_' . strtoupper($k);
                        $b = putenv("$item=$v");
                        var_dump($item);
                        var_dump($b);
                    }
                } else {
                    $b = putenv("$name=$val");
                }

            }
        }
        $a = ENV_PREFIX . strtoupper(str_replace('.', '_', 'DATABASE.hostname'));
        var_dump($a);
        $result = getenv($a, true);
        var_dump($result);

    }
    public function test1(){
        phpinfo();
    }


}