<?php
session_start();
header("content-type:text/html;charset=utf-8");
date_default_timezone_set("prc");
define('ROOT',dirname(__FILE__));
set_include_path(".".PATH_SEPARATOR.ROOT."/config".PATH_SEPARATOR.ROOT."/action".PATH_SEPARATOR.get_include_path());
include_once 'config.php';
include_once 'mysql.fun.php';
include_once 'doAction.fun.php';
include_once 'page.fun.php';
include_once 'upload.fun.php';
connect();
