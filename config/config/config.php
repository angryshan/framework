<?php
return array(

    'route' => array(
        'CTRL'  =>'index',
        'ACTION'=>'index',
    ),

    'database' => array(
        'database_type' => 'mysql',
        'database_name' => 'chat',
        'host' => 'b.cn',
        'username' => 'root',
        'password' => 'root',
        'charset' => 'utf8'
    ),

    'template' => array(
        'leftTag' => '{#',
        'rightTag' => '#}',
        'viewCss' => '__PUBLIC__',
        'viewCssCon' => '/public',
    ),

    'log' => array(
        'DRIVE'     => 'file',
        'OPTION'    => array(
            'PATH'=>LSS.'/log/'
        ),
    )


);