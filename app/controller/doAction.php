<?php
namespace app\controller;

use app\model\indexmodel;

class doAction{
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
}