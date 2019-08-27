<?php
namespace app\controller;
use app\model\indexmodel;
use config\lss;
class index extends lss{
    //登陆页面
    public function index(){
        $data = '视图文d件';
        lss::assign('data',$data);
        $this->assign('data',$data);
        $this->display('index');
        lss::display('index');
    }
    //登陆
    public function login(){
        $username = isset($_POST['username'])?$_POST['username']:'';
        $password = isset($_POST['password'])?md5($_POST['password']):'';

        $where = "username='$username' AND password='$password'";
        $model = new indexmodel();
        $row = $model->login('lss_member',$where);

        if ($row){
            $_SESSION['name'] = $row['username'];
            $_SESSION['id'] = $row['id'];
            $_SESSION['session_id'] = time();
            $_SESSION['identity'] = $row['identity'];
            $_SESSION['img'] = $row['img'];
            $wheres = "id=".$_SESSION['id'];#条件
            $row = $model->update('lss_member',['session_id'=>$_SESSION['session_id']],$wheres);
            if ($row){
                return json_encode(['code'=>200,'msg'=>'登陆成功','data'=>$_SESSION['identity']]);
            }
        }
        return json_encode(['code'=>400,'msg'=>'账户或密码错误']);

    }
    //渲染主页面
    public function home(){
        $this->assign('name',isset($_SESSION['name'])?$_SESSION['name']:'111');
        $this->assign('img',isset($_SESSION['img'])?$_SESSION['img']:'333');
        $this->assign('id',isset($_SESSION['id'])?$_SESSION['id']:'333');
        $this->display('home');
    }


}