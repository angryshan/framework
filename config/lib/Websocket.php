<?php
namespace config\lib;
class Websocket {
    public $server;
    public $data=[];
    public function __construct() {
        $this->server = new Swoole\WebSocket\Server("0.0.0.0", 9502);

        $this->server->on('open', function (swoole_websocket_server $server, $request) {
            echo "新用户 $request->fd 加入。\n";

            $this->data[$request->fd] = '匿名用户';//设置用户名
        });

        $this->server->on('message', function (Swoole\WebSocket\Server $ws, $request) {
            $chatmsg = json_decode($request->data, true);

            if(strstr($request->data,"#name#")){//用户设置昵称
                $this->data[$request->fd] = str_replace("#name#",'',$request->data);

            }else if($chatmsg['chattype'] == "publicchat") {
                $usermsg = 'logout';

                foreach($ws->connections as $key => $fd) {
                    $ws->push($fd, $usermsg);
                }
            }else if($chatmsg['chattype'] == "privatechat") {

                $usermsg = $chatmsg['chatFrom'].'#userfrom_id#'.$chatmsg['chatTo'].'#from_id#'.$chatmsg['chatmsg'].'#'.date('Y-m-d H:i:s');

                foreach($ws->connections as $key => $fd) {
                    $ws->push($fd, $usermsg);
                }
            }
        });

        $this->server->on('close', function ($ser, $fd) {
            echo "客户端-{$fd} 断开连接\n";
            unset($this->data[$fd]);//清楚连接仓库
        });

        $this->server->on('request', function ($request, $response) {
            // 接收http请求从get获取message参数的值，给用户推送
            // $this->server->connections 遍历所有websocket连接用户的fd，给所有用户推送
            foreach ($this->server->connections as $fd) {
                // 需要先判断是否是正确的websocket连接，否则有可能会push失败
                if ($this->server->isEstablished($fd)) {
                    $this->server->push($fd, $request->get['message']);
                }
            }
        });
        $this->server->start();
    }
}

