<?php
/**
 *
 * @author Bruce.cheng@carbit.com.cn
 * @date 16-3-23
 */
//检测项目名称是否定义
if (!defined('APP_NAME')) {
    exit("You don't defined APP_NAME!");
}

session_start();

/*统计执行时间*/
global $START_TIME; //页面开始执行时间
$START_TIME = microtime();

header('content-type:text/html;charset=utf8');
date_default_timezone_set('PRC');

//定义错误级别
error_reporting(E_ALL^E_NOTICE);
ini_set('display_errors', 1);

//定义框架相关路径
define('DS', DIRECTORY_SEPARATOR);                      //分割符
define('ROOT_PATH', realpath(__DIR__ . '/../') . DS);   //root路径
define('APP_PATH', ROOT_PATH . APP_NAME . DS);         //项目路径
define('CORE', __DIR__ . DS);                          //核心路径

//定义mvc相关路径
define('C_PATH', APP_PATH . 'Controller' . DS);    //控制器目录
define('V_PATH', APP_PATH . 'View' . DS);          //控制器目录
define('CACHE_PATH', APP_PATH . 'Cache' . DS);         //缓存目录

//配置相关路径
define('DEFAULT_CONFIG_FILE', CORE . 'Config.php');
define('USER_CONFIG_FILE', APP_PATH . 'Common/Config.php');

//其他
define('IS_AJAX', (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')));
define('NOW_TIME', $_SERVER['REQUEST_TIME']);
define('NOW_DATE', date('Y-m-d H:i:s', NOW_TIME));
define('__EXT__', '.php');

//引入框架文件
require CORE . 'Function.php';
require CORE . 'Kernel.php';

\Framework\Kernel::start();

