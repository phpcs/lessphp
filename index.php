<?php
header('content-type:text/html;charset=utf8');
//定义错误级别
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', 1);

define('APP_PATH', './App');


//项目根目录
require_once(__DIR__ . '/Framework/kernel.php');


\Framework\kernel::getInstance()->start();


