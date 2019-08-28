<?php
namespace app\controller;

use app\model\indexmodel;

class doAction{
    public $db;
    public function __construct()
    {
        $this->db = new indexmodel();
        session_start();
    }

    //登陆
    public function login(){
        $username = isset($_POST['username'])?$_POST['username']:'';
        $password = isset($_POST['password'])?md5($_POST['password']):'';

        $where = "username='$username' AND password='$password'";
        $row = $this->db ->login('lss_member',$where);

        if ($row){
            $_SESSION['name'] = $row['username'];
            $_SESSION['id'] = $row['id'];
            $_SESSION['session_id'] = time();
            $_SESSION['identity'] = $row['identity'];
            $_SESSION['img'] = $row['img'];
            $wheres = "id=".$_SESSION['id'];#条件
            $row = $this->db ->update('lss_member',['session_id'=>$_SESSION['session_id']],$wheres);
            if ($row){
                return json_encode(['code'=>200,'msg'=>'登陆成功','data'=>$_SESSION['identity']]);
            }
        }
        return json_encode(['code'=>400,'msg'=>'账户或密码错误']);
    }
    //注销
    public function dologout(){
        $where = "id=".$_SESSION['id'];#条件

        $row = $this->db ->update('lss_member',['session_id'=>0],$where);
        if ($row){
            $_SESSION = array();
            session_destroy();//销毁session
            header('location:/index/index');//跳转页面
        }
    }

    //判断是否登录
    public function check_login(){
        if (!$_SESSION){
            return json_encode(['code'=>400,'msg'=>'请登录']);
        }

    }

    //被迫下线
    public function two_logout(){
        if ($_SESSION){
            $where = "id=".$_SESSION['id'];#条件

            $row = $this->db ->find('lss_member','session_id',$where);
            if ($_SESSION['session_id'] != $row['session_id']){
                $_SESSION = array();
                session_destroy();//销毁session
                return json_encode(['code'=>400,'msg'=>'被迫下线']);
            }
        }
        return json_encode(['code'=>400,'msg'=>'登陆成功']);;
    }

    //注册
    public function register(){
        $arr = $_POST;#获取前端传过来的数据
        $arr['password'] = md5($_POST['password']);#密码
        $arr['createtime'] = time();#时间
        $arr['identity'] = 2;#角色身份

        if ($this->db ->insert('lss_member',$arr)){#调用insert方法，插入数据库
            return 200;
        }else{
            return "失败";
        }
    }
    //在线列表
    public function list_online(){
        $where = 'session_id!=0';
        $rows = $this->db->select('lss_member','id,username,email,img',$where);
        foreach ($rows as $k=>$v){
            $where1 = '';
        }
        return json_encode($rows);

    }
    //好友列表
    public function list_friends(){
        $where = '(uid='.$_SESSION['id'].' or fid='.$_SESSION['id'].')and del=1';
        $rows = $this->db->select('lss_friend','uid,fid',$where);

        if ($rows){
            foreach ($rows as $k=>$v){
                $fid = $v['uid']!=$_SESSION['id'] ? $v['uid'] : $v['fid'];
                $where1 = 'del=1 and id='.$fid;
                $data[$k] = $this->db->find('lss_member','id,username,email,img',$where1);
            }
        }

        return json_encode(isset($data)?$data:'');
    }

    //添加好友
    public function add_friend(){
        $arr = $_POST;#获取前端传过来的数据
        $arr['uid'] = $_SESSION['id'];
        $arr['createtime'] = time();#创建时间
        $arr['updatetime'] = time();#创建时间

        $where = 'del=1 and uid='.$arr['uid'].' and fid='.$arr['fid'];
        $rs = $this->db->find('lss_invited','id',$where);
        if ($rs){
            return json_encode(['code'=>500,'msg'=>'已发送过添加请求']);
        }

        if ($this->db->insert('lss_invited',$arr)){#调用insert方法，插入数据库
            return json_encode(['code'=>200,'msg'=>'添加朋友请求发送成功']);
        }else{
            return json_encode(['code'=>400,'msg'=>'添加朋友请求发送失败']);
        }
    }

    //同意/拒绝添加好友//注意使用事务处理（自行封装一个事务处理）
    public function agree_friend(){
        $arr = $_POST;#获取前端传过来的数据
        $arr['updatetime'] = time();#创建时间

        $where = 'id='.$arr['id'];
        $rs = $this->db->update('lss_invited',$arr,$where);
        if ($rs){
            $row = $this->db->find('lss_invited','uid,fid',$where);
            $this->db->insert('lss_friend',$row);
            return json_encode(['code'=>200,'msg'=>'操作成功']);
        }
        return json_encode(['code'=>400,'msg'=>'操作失败，请重新操作']);
    }

    //消息列表
    public function list_news(){
        $where = 'del=1 and (uid='.$_SESSION['id'].' or fid='.$_SESSION['id'].') order by createtime';
        $rs = $this->db->select('lss_invited','id,uid,fid,status,createtime',$where);
        if ($rs){
            foreach ($rs as $k=>$v){
                $fid = $v['uid']==$_SESSION['id'] ? $v['fid'] : $v['uid'];
                $where1 = 'del=1 and id='.$fid;
                $row = $this->db->find('lss_member','username,img',$where1);
                $rs[$k]['fName'] = $row['username'];
                $rs[$k]['img'] = $row['img'];
            }
            return json_encode(['code'=>200,'data'=>$rs]);
        }else{
            return json_encode(['code'=>400,'data'=>'']);
        }
    }
}