<?php
/**
 *
 * @author Bruce.cheng@carbit.com.cn
 * @date 16-3-23
 */

/*统计执行时间*/
global $START_TIME; //页面开始执行时间
global $CORE_START_TIME; //框架开始执行时间
$START_TIME = microtime(true);
$CORE_START_TIME = microtime(true);

//检测项目名称是否定义
if (!defined('APP_NAME')) {
    exit("You don't defined APP_NAME!");
}

header('content-type:text/html;charset=utf8');
date_default_timezone_set('PRC');

//定义错误级别
error_reporting(E_ALL);
ini_set('display_errors', 1);

//定义相关路径
define('DS', DIRECTORY_SEPARATOR);
define('ROOT_PATH', realpath(__DIR__ . '/../') . DS);   //root路径
define('APP_PATH', ROOT_PATH . APP_NAME . DS);         //项目路径
define('CORE', __DIR__ . DS);                          //核心路径

define('DEFAULT_CONFIG_FILE', CORE . 'Config.php');
define('USER_CONFIG_FILE', APP_PATH . 'Common/Config.php');

//引入框架文件
require CORE . 'Function.php';
require CORE . 'Kernel.php';


$app = new \Framework\Kernel();



