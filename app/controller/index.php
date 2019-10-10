<?php
namespace app\controller;
use app\model\indexmodel;
use config\lib\controller;
use config\lib\lssRedis;
use config\loader;
class index extends controller {
    //登陆页面
    public function index(){
        $data = '视图文d件';
        $this->assign('data',$data);
        $this->display('index');
        getSet('a','a',[]);
    }

    //渲染主页面
    public function home(){
        $this->assign('name',isset($_SESSION['name'])?$_SESSION['name']:'111');
        $this->assign('img',isset($_SESSION['img'])?$_SESSION['img']:'333');
        $this->assign('id',isset($_SESSION['id'])?$_SESSION['id']:'333');
        $this->display('home');
    }


}