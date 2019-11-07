<?php
/**
 * 入口文件
 * 1.定义各种常量
 * 3.预加载文件包含进来
 * 4.自动加载方法
 * 5.整个框架跑起来
 */
define('APP_PATH',dirname(__FILE__));#当前框架所在的根目录
define('CONFIG',APP_PATH.'/config');#核心文件
define('APP',APP_PATH.'/app');#项目文件
define('MODULE','app');#项目文件
define('_PUBLIC',APP_PATH.'/public');
define('SOCKET',APP_PATH.'/config/lib/swoole');
define('ROOT_PATH', APP_PATH . '/');
define('ENV_PREFIX', 'PHP_');// 环境变量的配置前缀

// 加载环境变量配置文件
if (is_file(ROOT_PATH . '.env')) {
    $env = parse_ini_file(ROOT_PATH . '.env', true);
    foreach ($env as $key => $val) {
        $name = ENV_PREFIX . strtoupper($key);

        if (is_array($val)) {
            foreach ($val as $k => $v) {
                $item = $name . '_' . strtoupper($k);
                putenv("$item=$v");
            }
        } else {
            putenv("$name=$val");
        }
    }
}
include CONFIG.'/common/function.php';
include CONFIG . '/loader.php';

spl_autoload_register('\config\loader::load');

\config\loader::run();