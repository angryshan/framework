<?php
use config\lib\Env;
return array(
    //初始路由
    'route' => array(
        'CTRL'  =>'index',
        'ACTION'=>'index',
        //是否自己配置路由
        'isOpenRoute'=>true,
    ),

    //数据库配置
    'database' => array(
        'database_type' => 'mysql',
        'database_name' => Env::get('database.database',false)?Env::get('database.database',false):'chat',
        'host' => '127.0.0.1',
        'username' => Env::get('database.username',false)?Env::get('database.username',false):'root',
        'password' => Env::get('database.password',false)?Env::get('database.password',false):'lss633',
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
            'PATH'=>APP_PATH.'/log/'
        ),
    ),

    //是否开启debug
    'debug' => 'on',//off
    //是否忽略警告
    'warning' => false,

    //缓存配置
    'redis' => [
        'host'    => '0.0.0.0',
        'port'    => '6937',
    ],

    'webSocket' => [
        'host'    => '0.0.0.0',
        'port'    => '9502',
    ]

);