//公共方法


//注册
function reg() {
    var username = $("#username2").val(),
        password = $("#pwd2").val(),
        repwd = $("#repwd").val(),
        phone = $("#phone").val(),
        email = $("#eml").val();
    if(username=="" || username==null){
        $("#names").empty();
        $("#username2").after("<span id='names' style='color: red'>用户名不能为空</span>");
        return false;
    }if(password=="" || password==null){
        $("#pwd3").empty();
        $("#pwd2").after("<span id='pwd3' style='color: red'>密码不能为空</span>");return false;
    }if(repwd=="" || repwd==null){
        $("#repwd2").empty();
        $("#repwd").after("<span id='repwd2' style='color: red'>确认密码不能为空</span>");return false;
    }
    else if(repwd !=password){
        $("#repwd2").empty();
        $("#repwd").after("<span id='repwd2' style='color: red'>两次密码不一致</span>");return false;
    }
    if(phone=="" || phone==null || phone.length!=11){
        $("#phone2").empty();
        $("#phone").after("<span id='phone2' style='color: red'>请正确填写手机号</span>");return false;
    }
    if(email=="" || email==null){
        $("#eml2").empty();
        $("#eml").after("<span id='eml2' style='color: red'>邮箱不能为空</span>");return false;
    }else {
        post_data ={
            username:username,
            password:password,
            phone:phone,
            email:email
        };
        $.post('doAction.php?act=register',post_data,function (data) {
            console.log(data);
            if (data==200){
                alert("注册成功，请在左侧登录界面登录");
                window.location = 'main.php';
            }else {
                alert("注册失败，用户名已被注册");
            }
        })
    }
}
//登录
function login() {
    var username = $("#username").val(),
        password = $("#pwd").val();
    if(username=="" || username==null){
        $("#names").empty();
        $("#username").after("<span id='names' style='color: red'>用户名不能为空</span>");return false;
    }if(password=="" || password==null){
        $("#password2").empty();
        $("#pwd").after("<span id='password2' style='color: red'>密码不能为空</span>");return false;
    }else {
        post_data ={
            username:username,
            password:password
        };
        $.post('/doAction/login',post_data,function (data) {
            data = JSON.parse(data);
            if (data.code==200){
                window.location = '/index/home'
            }
            alert(data.msg);
        })
    }
}
//跳转到注册页面
function zhuce() {
    window.location = 'regist.html';
}
