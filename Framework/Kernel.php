<?php
namespace Framework;

/**
 *
 * @author Bruce.cheng@carbit.com.cn
 * @date 16-2-18
 */
define('ROOT', realpath('./'));
define('CORE', __DIR__ . '/');
require CORE.'Function.php';

class Kernel
{

    static protected $_instance;

    static private $_config = array();

    private function __construct(){}

    static public function auto_load($classname)
    {
        if (stripos($classname, '\\')) {
            $str = str_replace('\\', '/', $classname);
        }
        self::includeFile(ROOT . '/' . $str . '.php');
    }

    static function includeFile($file)
    {
        if (file_exists($file)) {
            include_once $file;
        }
    }

    static public function _init()
    {
        header('content-type:text/html;charset=utf8');
        //定义错误级别
        error_reporting(E_ALL ^ E_NOTICE);
        ini_set('display_errors', 1);
        self::$_config = require __DIR__ . '/Config.php';
        date_default_timezone_set('PRC');
        //spl_autoload_register('\Framework\Kernel::auto_load');
        spl_autoload_register('\Framework\Kernel::auto_load');
        self::start();
    }

    static public function start()
    {
        $filter_param = array('<','>','"',"'",'%3C','%3E','%22','%27','%3c','%3e');
        $query_str = str_replace($filter_param, '', $_SERVER['REQUEST_URI']);
        switch (self::$_config['URL_MOD']) {
            case 1:     //传统模式
                preg_match('/c=([a-zA-Z]+\w+)/', $query_str, $controller);
                preg_match('/a=([a-zA-Z]+\w+)/', $query_str, $action);
                $c = $controller[1] ? ucfirst($controller[1]) : self::$_config['D_C'];
                $a = $action[1] ? $action[1] : self::$_config['D_A'];
                break;
            case 2:    //pathinfo模式
                $query_arr = explode('/', self::_parse_request_uri());
                $c = ucfirst($query_arr[0]);
                $a = $query_arr[1] ?:self::$_config['D_C'];
                break;
        }
        $c_name = "\\App\\Controller\\" . $c.self::$_config['C_NAME'];
        if (class_exists($c_name)) {
            $obj = new $c_name;
            $reflectionMethod = new  \ReflectionMethod ($obj, $a);
            $reflectionMethod->invoke($obj, $a);
        } else {
            halt('Controller or action not exits!');
        }
    }

    static public function _parse_request_uri()
    {
        if (!isset($_SERVER['REQUEST_URI'], $_SERVER['SCRIPT_NAME'])) {
            return '';
        }
        $uri = parse_url('http://dummy' . $_SERVER['REQUEST_URI']);
        $query = isset($uri['query']) ? $uri['query'] : '';
        $uri = isset($uri['path']) ? $uri['path'] : '';

        if (strpos($uri, $_SERVER['SCRIPT_NAME']) === 0) {
            $uri = (string)substr($uri, strlen($_SERVER['SCRIPT_NAME']));
        } elseif (strpos($uri, dirname($_SERVER['SCRIPT_NAME'])) === 0) {
            $uri = (string)substr($uri, strlen(dirname($_SERVER['SCRIPT_NAME'])));
        }

        return trim($uri, '/');
    }

    private function __clone(){}

}




