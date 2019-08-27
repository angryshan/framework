<?php
/**
 * 后端操作
 */
require_once 'include.php';

check_login();
$act = isset($_REQUEST['act']) ? $_REQUEST['act'] : '';
$id=isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
if ($act == 'dologin'){//登录
    echo dologin();
} elseif($act == 'register'){//注册
    echo register();
}elseif($act == 'edit_pwd'){//修改密码
    echo edit_pwd();
}elseif($act == 'dologout'){//注销登录
    dologout();
}elseif($act == 'list_friends'){//朋友列表
    echo list_friends();
}elseif($act == 'list_online'){//在线列表
    echo list_online();
}elseif($act == 'add_friend'){//添加朋友
   echo add_friend();
}elseif($act == 'agree_friend'){//同意/拒绝添加朋友
   echo agree_friend();
}elseif($act == 'list_news'){//消息列表
   echo list_news();
}elseif($act == 'two_logout'){//被迫下线
   echo two_logout();
}elseif($act == 'add_reply'){//上传文件
    echo add_reply();
}elseif($act == 'find_pwd'){//上传文件
    echo find_pwd();
}

?>
