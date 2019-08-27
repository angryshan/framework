<?php
include_once 'include.php';
check_login();
?>
<!DOCTYPE html>
<html>

<!-- Head -->
<head>

	<title><?=$_SESSION['name']?$_SESSION['name']:''?></title>

	<!-- For-Mobile-Apps -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="keywords" content="Friends Chat History Widget Responsive, Login Form Web Template, Flat Pricing Tables, Flat Drop-Downs, Sign-Up Web Templates, Flat Web Templates, Login Sign-up Responsive Web Template, Smartphone Compatible Web Template, Free Web Designs for Nokia, Samsung, LG, Sony Ericsson, Motorola Web Design" />
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
	<!-- //For-Mobile-Apps -->

	<!-- Style --> <link rel="stylesheet" href="public/css/style.css" type="text/css" media="all">

	<!-- Web-Fonts -->
		<link href='//fonts.googleapis.com/css?family=Raleway:400,500,600,700,800' rel='stylesheet' type='text/css'>
		<link href='//fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>

	<!-- //Web-Fonts -->

</head>
<!-- //Head -->

<!-- Body -->
<body  style="overflow:hidden;" >
<!--主页面板-->

    <h1>快来聊天<br><img style="width: 55px;border-radius: 28%;" src="<?=$_SESSION['img']?$_SESSION['img']:''?>">
        <a href="doAction.php?act=dologout" class="friends" style="font-size: 1px" onclick="freshen()">退出</a>
    </h1>
    <div class="container w3layouts agileits" id="chat_index">
        <div id="chatbox">

            <div id="topmenu">
                <span style="float: left;margin-left: 10px;" class="friends" id="myname"><?=isset($_SESSION['name'])?$_SESSION['name']:'';?></span>
                <a href="#" class="topmenuA" onclick="changeMenu(1)" id="menu1">在线聊天</a>
                <a href="#" onclick="changeMenu(2)" id="menu2">我的朋友</a>
                <em style="color: cyan;margin-top: -60px;float: right;cursor:pointer;margin-right: 5px;" onclick="list_news()">
                    <b style="color: red;margin-top: -26px;float: left;font-size: 30px;">.</b>消息
                </em>
            </div>

            <div id="friendslist">

                <div id="friends"></div>
                <div id="search">
                    <input type="text" id="searchfield" placeholder="Search friend...">
                </div>

            </div>

            <div id="chatview" class="p1">

                <div id="profile">
                    <div id="close">
                        <div class="cy"></div>
                        <div class="cx"></div>
                    </div>
                    <p id="name">Bucky Barnes</p>
                    <em id="to_id" style="display: none">wintersoldier@gmail.com</em>
                    <span>wintersoldier@gmail.com</span>
                    <br><a id="add_friend" style="margin-left: 200px;cursor:pointer;color: gold;" onclick="add_friend()">添加为好友</a>
                </div>

                <div id="chat-messages">

                    <label>Monday 01</label>

                    <div class="message w3layouts">
                        <img src="public/images/captain-america.jpg">
                        <div class="bubble">
                            Why are you protecting me?
                            <span>4 min</span>
                        </div>
                    </div>
                </div>
            </div>
            <div id="sendmessage" style="display: none">
                <input type="text" id="chatMessages" placeholder="Send message...">
                <button id="send" onclick="send_message()"></button>
            </div>
        </div>
    </div>


<!--消息面板-->
    <div class="container w3layouts agileits" id="new_index" style="display:none;">
        <div id="chatbox">
            <div id="topmenu">
                <span class="friends">消息</span>
                <em style="color: cyan;margin-top: -17px;float: right;cursor:pointer;margin-right: 5px;" onclick="$('#chat_index').show();$('#new_index').hide();">返回</em>
            </div>

            <div id="newsList">
                <div class="news">
                    <img src="public/images/bg.png">
                    <p>
                        <strong>Bucky Barnes</strong><br>
                        <a href="#" >拒绝</a>
                        <a href="#" style="right: 39px;">同意</a>
                    </p>
                </div>
                <div class="news">
                    <img src="public/images/bg.png">
                    <p>
                        <strong>Bucky Barnes</strong><br>
                        <a href="#" >拒绝</a>
                        <a href="#" style="right: 39px;">同意</a>
                    </p>
                </div>
            </div>

        </div>
    </div>

<!--脚标-->
	<div class="footer w3layouts agileits">

	</div>


    <!-- Custom-JavaScript-File-Links -->
    <!-- Default-JavaScript --> <script src="public/js/jquery.min.js"></script>
    <!-- Tabs-JavaScript -->
    <!-- //Custom-JavaScript-File-Links -->
</body>
<!-- //Body -->
<script type="text/javascript">
    var myID = <?=isset($_SESSION['id'])?$_SESSION['id']:'1';?>;
    var myImg = '<?=isset($_SESSION['img'])?$_SESSION['img']:"2";?>';

</script>
<!-- Custom-JavaScript-File-Links -->
<script src="public/js/tabs.js"></script>
<!-- //Custom-JavaScript-File-Links -->
</html>
