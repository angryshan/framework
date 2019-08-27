<?php
/**
 * 入口文件
 * 1.定义各种常量
 * 2.是否开启debug
 * 3.预加载文件包含进来
 * 4.自动加载方法
 * 5.整个框架跑起来
 */
define('LSS',dirname(__FILE__));#当前框架所在的根目录
define('CONFIG',LSS.'/config');#核心文件
define('APP',LSS.'/app');#项目文件
define('MODULE','app');#项目文件
define('_PUBLIC',LSS.'/public');
define('DEBUG',true);#debug


if (DEBUG){
    ini_set('display_errors','on');
}else{
    ini_set('display_errors','off');
}


include CONFIG.'/common/function.php';
include CONFIG.'/lss.php';

spl_autoload_register('\config\lss::load');

\config\lss::run();