<?php
/**
 * 后端操作
 * Date: 2019/1/29 0029
 */
//登录
function dologin(){
    $username = isset($_POST['username'])?$_POST['username']:'';
    $password = isset($_POST['password'])?md5($_POST['password']):'';

    $where = "username='$username' AND password='$password'";
    $row = find('lss_member','*',$where);

    if ($row){
        $_SESSION['name'] = $row['username'];
        $_SESSION['id'] = $row['id'];
        $_SESSION['session_id'] = time();
        $_SESSION['identity'] = $row['identity'];
        $_SESSION['img'] = $row['img'];
        $wheres = "id=".$_SESSION['id'];#条件
        $row = update('lss_member',['session_id'=>$_SESSION['session_id']],$wheres);
        if ($row){
            return $_SESSION['identity'];
        }
    }
    return 400;

}
//注销
function dologout(){
    $where = "id=".$_SESSION['id'];#条件
    $row = update('lss_member',['session_id'=>0],$where);
    if ($row){
        $_SESSION = array();
        session_destroy();//销毁session
        header('location:index.html');//跳转页面
    }
}
//判断是否登录
function check_login(){
    if (!$_SESSION){
        msg('请登录','index.html');
    }

}

//被迫下线
function two_logout(){
    if ($_SESSION){
        $where = "id=".$_SESSION['id'];#条件
        $row = find('lss_member','session_id',$where);
        if ($_SESSION['session_id'] != $row['session_id']){
            $_SESSION = array();
            session_destroy();//销毁session
//            msg('该账号已经在别处登陆，请及时修改密码重新登陆','index.html');
            return 400;
        }
    }
    return 200;
}

//注册
function register(){
    $arr = $_POST;#获取前端传过来的数据
    $arr['password'] = md5($_POST['password']);#密码
    $arr['createtime'] = time();#时间
    $arr['identity'] = 2;#角色身份

    if (insert('lss_member',$arr)){#调用insert方法，插入数据库
        return 200;
    }else{
        return "失败";
    }
}
//在线列表
function list_online(){
    $where = 'session_id!=0';
    $rows = select('lss_member','id,username,email,img',$where);
    foreach ($rows as $k=>$v){
        $where1 = '';
    }
    return json_encode($rows);

}
//好友列表
function list_friends(){
    $where = '(uid='.$_SESSION['id'].' or fid='.$_SESSION['id'].')and del=1';
    $rows = select('lss_friend','uid,fid',$where);

    if ($rows){
        foreach ($rows as $k=>$v){
            $fid = $v['uid']!=$_SESSION['id'] ? $v['uid'] : $v['fid'];
            $where1 = 'del=1 and id='.$fid;
            $data[$k] = find('lss_member','id,username,email,img',$where1);
        }
    }

    return json_encode(isset($data)?$data:'');
}

//添加好友
function add_friend(){
    $arr = $_POST;#获取前端传过来的数据
    $arr['uid'] = $_SESSION['id'];
    $arr['createtime'] = time();#创建时间
    $arr['updatetime'] = time();#创建时间

    $where = 'del=1 and uid='.$arr['uid'].' and fid='.$arr['fid'];
    $rs = find('lss_invited','id',$where);
    if ($rs){
        return json_encode(['code'=>500,'msg'=>'已发送过添加请求']);
    }

    if (insert('lss_invited',$arr)){#调用insert方法，插入数据库
        return json_encode(['code'=>200,'msg'=>'添加朋友请求发送成功']);
    }else{
        return json_encode(['code'=>400,'msg'=>'添加朋友请求发送失败']);
    }
}

//同意/拒绝添加好友//注意使用事务处理（自行封装一个事务处理）
function agree_friend(){
    $arr = $_POST;#获取前端传过来的数据
    $arr['updatetime'] = time();#创建时间

    $where = 'id='.$arr['id'];
    $rs = update('lss_invited',$arr,$where);
    if ($rs){
        $row = find('lss_invited','uid,fid',$where);
        insert('lss_friend',$row);
        return json_encode(['code'=>200,'msg'=>'操作成功']);
    }
    return json_encode(['code'=>400,'msg'=>'操作失败，请重新操作']);
}

//消息列表
function list_news(){
    $where = 'del=1 and (uid='.$_SESSION['id'].' or fid='.$_SESSION['id'].') order by createtime';
    $rs = select('lss_invited','id,uid,fid,status,createtime',$where);
    if ($rs){
        foreach ($rs as $k=>$v){
            $fid = $v['uid']==$_SESSION['id'] ? $v['fid'] : $v['uid'];
            $where1 = 'del=1 and id='.$fid;
            $row = find('lss_member','username,img',$where1);
            $rs[$k]['fName'] = $row['username'];
            $rs[$k]['img'] = $row['img'];
        }
        return json_encode(['code'=>200,'data'=>$rs]);
    }else{
        return json_encode(['code'=>400,'data'=>'']);
    }

}
//修改密码
function edit_pwd(){
    $arr = $_POST;#获取参数
    $arr['oldpwd'] = md5($arr['oldpwd']);#旧密码加密

    $where = "id=".$_SESSION['id'];#条件
    $row = find('lss_member','*',$where);#查询该用户的id

    if ($row){
        if ($row['password']==$arr['oldpwd']){
            $data = ['password'=>md5($arr['newpwd'])];
            $edit = update('lss_member',$data,$where);#修改
            if ($edit){
                $_SESSION = array();
                session_destroy();//销毁session
                return 200;
            }
        }
    }
    return '修改密码失败';
}
//发布公告
function add_gonggao(){
    $arr = $_POST;#获取参数
    $arr['createtime'] = time();#时间
    $arr['updatetime'] = time();#时间
    $arr['uid'] = $_SESSION['id'];#获取用户id
    if (insert('lss_gonggao',$arr)){#调用insert方法，插入数据库
        return 200;
    }else{
        return "发布失败";
    }
}
//修改公告
function update_gonggao(){
    $arr = $_POST;
    $arr['updatetime'] = time();
    $arr['uid']=$_SESSION['id'];
    $res = update('lss_gonggao',$arr,'id='.$arr['id']);
    if ($res){
        return 200;
    }else{
        return '修改失败，该条公告已存在';
    }
}
//文件上传
function up_file(){
    $data = uploadFile('./uploads');
    if ($data[0]['error']==0){
        $res = [
            'name'=>'uploads'.'/'.date('Ym').'/'.$data[0]['name'],
            'code'=>200  #200表示成功，也可以用别的数表示，一般用200
        ];
        return json_encode($res);
    }else{
        return false;
    }

}
//添加实验、资料、练习
function add_kecheng(){
    $arr = $_POST;
    $arr['createtime'] = time();
    $arr['uid']=$_SESSION['id'];
    $table = $arr['table'];
    unset($arr['table']);
    $res = insert($table,$arr);
    if ($res){
        return 200;
    }else{
        //添加失败，删除已上传的文件
        if (file_exists("../uploads/".date('Ym').$arr['file_url'])){
            unlink("../uploads/".date('Ym').$arr['file_url']);
        }
        return '添加失败，课程名称已存在';
    }
}
//修改实验、资料、练习
function update_kecheng(){
    $arr = $_POST;
    $arr['updatetime'] = time();
    $arr['uid']=$_SESSION['id'];
    $table = $arr['table'];
    unset($arr['table']);
    $res = update($table,$arr,'id='.$arr['id']);
    if ($res){
        return 200;
    }else{
        //添加失败，删除已上传的文件
        if (file_exists("../uploads/".date('Ym').$arr['file_url'])){
            unlink("../uploads/".date('Ym').$arr['file_url']);
        }
        return '修改失败，课程名称已存在';
    }
}
//删除实验、资料、练习、留言、公告、用户
function del(){
    $arr = $_POST;
    $arr['updatetime'] = time();
    $table = $arr['table'];
    unset($arr['table']);
    $res = update($table,$arr,'id='.$arr['id']);
    if ($res){
        return 200;
    }
    return '删除失败';
}
//添加留言、回复留言
function add_reply(){
    if ($_SESSION){
        $arr = $_POST;
        $arr['createtime'] = time();
        $arr['uid']=$_SESSION['id'];
        $res = insert('lss_message',$arr);
        if ($res){
            return 200;
        }else{
            return '操作失败';
        }
    }else{
        return '您还没有登录,请登录后操作';
    }

}
//找回密码
function find_pwd(){
    $arr = $_POST;#获取参数

    $where = "username='".$arr['username']."' and email='".$arr['email']."'";#条件
    $row = find('lss_member','id',$where);#查询该用户的id

    if ($row){
        $data = ['password'=>md5($arr['password'])];#密码加密
        $edit = update('lss_member',$data,$row['id']);#修改
        if ($edit){
            return 200;
        }
    }
    return 400;
}