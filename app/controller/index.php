<?php
namespace app\controller;
use config\lib\controller;
use \config\lib\drive\mysql\Mysql;

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
        $row = Mysql::table('lss_member')->where(['username'=>'king','password'=>md5('king')])->select(true);
        $b = Mysql::getSql();

        var_dump($b);
        $gift = [];

        $need_gift[1] = 500 -$gift[0]>0 ? 500 -$gift[0] : 0;//还差多少礼物数量可过第一关
        $need_gift[2] = 25 -$gift[1]>0 ? 25 -$gift[1] : 0;//还差多少礼物数量可过第二关
        $need_gift[3] = 2 -$gift[2]>0 ? 2 -$gift[2] : 0;
        $need_gift[4] = $need_gift[2] == 0 ? (75 -$gift[1]>0 ? 75 -$gift[1] : 0 ) : 50;//还差多少礼物数量可过第三关(第二关和第三关的礼物重叠，所以先满足第二关)
        $need_gift[5] = $need_gift[3] == 0 ? (7 -$gift[2]>0 ? 7 -$gift[2] : 0) : 5;
    }


}