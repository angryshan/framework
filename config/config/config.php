<?php
return array(
    //初始路由
    'route' => array(
        'CTRL'  =>'index',
        'ACTION'=>'index',
    ),

    //数据库配置
    'database' => array(
        'database_type' => 'mysql',
        'database_name' => 'chat',
        'host' => 'b.cn',
        'username' => 'root',
        'password' => 'root',
        'charset' => 'utf8'
    ),

    //smaty配置
    'template' => array(
        'leftTag' => '{#',
        'rightTag' => '#}',
        'viewCss' => '__PUBLIC__',
        'viewCssCon' => '/public',
    ),

    //日志配置
    'log' => array(
        'DRIVE'     => 'file',
        'OPTION'    => array(
            'PATH'=>LSS.'/log/'
        ),
    ),

    //是否开启debug
    'debug' => true,
    //是否忽略警告
    'warning' => true,

    'redis' => [
        'host'    => '0.0.0.0',
        'port'    => '6937',
    ],

    'webSocket' => [
        'host'    => '0.0.0.0',
        'port'    => '9502',
    ]

);