var msgPlace = document.getElementById("chat-messages");
var friends = document.getElementById("friends");

var chatto,chatToImg,data1,data2,list;
var array =[];
var key = 'aaa';

var wsServer = 'ws://139.196.206.138:9502';
// var wsServer = 'ws://192.168.222.100:9502';
var websocket = new WebSocket(wsServer);
websocket.onopen = function(evt,e){
	// websocket.send("#name#"+text);
	console.log('从服务器获取到的数据:',evt);
	freshen();//若有人加入了聊天，即刷新好友列表
}
websocket.onmessage = function(evt){
	if (evt.data=='logout'){//判断是否有人注销/登录
		action(1);
		$.getJSON("/doAction/two_logout",function(data){
			if (data==400){
				alert('该账号已经在别处登陆，请及时修改密码重新登陆');
				window.location = '/';
			}
		});
		return false;
	}

	//入栈存数据，将聊天内容存在浏览器缓存中
	var data = evt.data;
	console.log(data);
	array.push(data);
	saveData(key,array);

	messageList(data);//将数据显示

	if($("#chatview").is(':hidden')){
		var b= list[0];
		$("#user"+b).attr('class','status away');//如果是未查看的消息，就显示黄点，已查看显示绿点
	}
}
websocket.onclose = function(e){
	console.log('websocket 断开: ' + e.code + ' ' + e.reason + ' ' + e.wasClean);
	console.log(e)
	console.log("服务器拒绝");
}
websocket.onerror = function(evt,e){
	console.log('错误:'+evt);
}
websocket.connections = function(evt,e){
	console.log('错误:'+evt);
}





//好友列表
function action(type) {
	var url;
	if(type==1){
		url = '/doAction/list_online';//在线列表
	}else {
		url = '/doAction/list_friends';//好友列表
	}
	friends.innerHTML = '';
	$.getJSON(url,function(data){
		list = eval(data);
		if (list=='' || list==undefined){
			friends.innerHTML += '<div style="color: white;text-align: center;margin-top: 70px;"> 未添加没有朋友哦~ </div>';
		} else {
			for (var i in list) {
				if (list[i]['id'] == myID) {
					continue;
				}
				friends.innerHTML +=
					'<div class="friend"> ' +
					'<img src="'+list[i]['img']+'"> ' +
					'<p> ' +
					'<strong> '+list[i]['username']+' </strong> ' +
					'<em  style="display:none ">'+list[i]['id']+'</em> ' +
					'<span>'+list[i]['email']+'</span> ' +
					'</p> ' +
					'<div id="user'+list[i]['id']+'" class="status available"></div> ' +
					'</div>';//inactive   away
			}
			table();//初始化聊天内容列表
		}

	});
}
//发送聊天信息给socket
function send_message(){
	var text = document.getElementById('chatMessages').value;
	chatto = $("#to_id").text();
	var msg = JSON.stringify({"chattype":'privatechat', "chatTo":chatto,"chatFrom":myID, "chatmsg":text});
	if(msg != "" && text !=""){
		document.getElementById('chatMessages').value = '';
		websocket.send(msg);
	}
}

//聊天内容存储
function saveData(key,dataArr) {
	var str = JSON.stringify(dataArr);//将数组转换成json字符串
	localStorage.setItem(key,str);//存储
}
//获取聊天内容
function getData(){
	var str = localStorage.getItem(key);//根据key值获取localStorage存储的值，此时是json字符串
	array =JSON.parse(str);//把json字符串转换成对象
	if (array==null){
		array=[];
	}
	msgPlace.innerHTML = '<label>置顶啦</label>';
	for (var i in array){
		messageList(array[i])
	}
}

//聊天内容按部就班显示
function messageList(data) {
	data1 = data.substring(data.indexOf('#from_id#'),-1);
	data2 = data.substring(data.lastIndexOf('#from_id#')+9);
	var data3 = data2.split('#');
	if(!isNaN(data)||isNaN(Date.parse(data))){
		return false;
	}
	list = data1.split('#userfrom_id#');
	var time1 = timeMatch(data3[1]);
	if ((list[0]==chatto && myID == list[1]) || (list[0]==myID &&chatto == list[1])) {


		var right = chatto == list[0] ? '' : ' right agileits';
		var img = chatto == list[0] ? chatToImg : myImg ;

		msgPlace.innerHTML += '<div class="message'+right+'">\n' +
			'<img src="'+img+'">\n' +
			'<div class="bubble">\n' + data3[0] +
			'<span>'+time1[4]+':'+time1[5]+':'+time1[6]+'</span>\n' +
			'</div>\n' +
			'</div>';
		msgPlace.scrollTop = msgPlace.scrollHeight;//保持滚动条在最底部

	}
}

//刷新好友列表
function freshen() {
	var msg = JSON.stringify({"chattype":'publicchat'});
	websocket.send(msg);
}

//时间的正则表达式
function timeMatch(dateStr) {

	//假如是2017-10-22 10:11:12
	var reg = /^(\d{4})-(\d{1,2})-(\d{1,2}) ([0-9]{1,2}):([0-9]{1,2})?:([0-5]{0,1}[0-9]{1})?$/;
	console.log(dateStr);
	return dateStr.match(reg);


}

//切换菜单内容
function changeMenu(type) {
	var oType = type==1?2:1;
	$('#menu'+type).attr('class','topmenuA');
	$('#menu'+oType).removeAttr('class');
	action(type);
}

//好友列表与聊天内容页面的切换
function table() {
	$(".friend").each(function(){
		$(this).click(function(){
			var childOffset = $(this).offset();
			var parentOffset = $(this).parent().parent().offset();
			var childTop = childOffset.top - parentOffset.top;
			var clone = $(this).find('img').eq(0).clone();
			var top = childTop+12+"px";
			$('#sendmessage').show();

			$(clone).css({'top': top}).addClass("floatingImg").appendTo("#chatbox");

			var name = $(this).find("p strong").html();
			var email = $(this).find("p span").html();
			var goodId = $(this).find("p em").html();
			$("#profile p").html(name);
			$("#profile span").html(email);
			$("#profile em").html(goodId);
			chatto = goodId;
			chatToImg = $(".floatingImg").attr('src');
			$("#profile a").show();
			if ($('#menu2').attr('class') == 'topmenuA'){
				$("#profile a").hide();
			}

			getData(myID+goodId);//获取缓存中的聊天内容

			setTimeout(function(){$("#profile p").addClass("animate");$("#profile").addClass("animate");}, 100);
			setTimeout(function(){
				$("#chat-messages").addClass("animate");
				$('.cx, .cy').addClass('s1');
				setTimeout(function(){$('.cx, .cy').addClass('s2');}, 100);
				setTimeout(function(){$('.cx, .cy').addClass('s3');}, 200);
			}, 150);

			$('.floatingImg').animate({
				'width': "68px",
				'left':'108px',
				'top':'20px'
			}, 200);

			$(".message").not(".right").find("img").attr("src", $(clone).attr("src"));
			$(".message").filter(".right").attr("src", '\''+myImg+'\'');
			$('#friendslist').fadeOut();
			$('#chatview').fadeIn();
			// $("#user"+goodId).attr('class','status available');
			msgPlace.scrollTop = msgPlace.scrollHeight;

			$('#close').unbind("click").click(function(){
				$('#sendmessage').hide();
				$("#chat-messages, #profile, #profile p").removeClass("animate");
				$('.cx, .cy').removeClass("s1 s2 s3");
				$('.floatingImg').animate({
					'width': "40px",
					'top':top,
					'left': '12px'
				}, 200, function(){$('.floatingImg').remove()});

				setTimeout(function(){
					$('#chatview').fadeOut();
					$('#friendslist').fadeIn();
				}, 50);
			});

		});
	});
}

//添加朋友
function add_friend() {
	post_data ={
		fid:chatto
	};
	$.post('/doAction/add_friend',post_data,function (data) {
		data = JSON.parse(data);
		console.log(data);
		alert(data.msg);
	})
}
//同意或拒绝添加朋友
function agree_friend(id,status) {
	post_data ={
		id:id,
		status:status
	};
	$.post('/doAction/agree_friend',post_data,function (data) {
		data = JSON.parse(data);
		console.log(data);
		alert(data.msg);
		list_news();
	})
}
//消息列表
function list_news() {
	$.getJSON('/doAction/list_news',function (data) {
		$('#chat_index').hide();
		$('#new_index').show();
		data = eval(data);
		var html='';
		if (data.code==200){
			var list = data.data;
			for (var i in list){
				var type = list[i]['uid']==myID ? 1 : 2;
				var status = list[i]['status'] ? list[i]['status'] : 0;
				html += '<div class="news"><img src="'+list[i]['img']+'"><p>';
				if (type==1){
					html += '<strong>您请求添加'+list[i]['fName']+'为好友</strong><br>\n';
					if (status==0){
						html += '<em>等待同意</em>\n';
					}else if (status==1){
						html += '<em>对方已同意</em>\n';
					} else if (status==2){
						html += '<em>对方已拒绝</em>\n';
					}
				}else {
					html += '<strong>'+list[i]['fName']+'请求添加您为好友</strong><br>';
					if (status==0){
						html += '<a href="#" onclick="agree_friend('+list[i]['id']+',2)">拒绝</a>\n' +
							'<a href="#" onclick="agree_friend('+list[i]['id']+',1)" style="right: 39px;">同意</a>\n' ;
					}else if (status==1){
						html += '<em>已同意</em>\n';
					} else if (status==2){
						html += '<em>已拒绝</em>\n';
					}
				}


				html += '</p></div>'
			}
		}

		$('#newsList').html(html);
	})
}