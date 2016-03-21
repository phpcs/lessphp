<?php
namespace Framework;

/**
 *
 * @author Bruce.cheng@carbit.com.cn
 * @date 16-2-18
 */
define('ROOT', realpath('./'));

class kernel
{

    static protected $_instance;

    static private $_config = array();


    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

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

    public function start()
    {
        require __DIR__ . '/function.php';
        self::$_config = require __DIR__ . '/config.php';
        $query_str = $_SERVER['REQUEST_URI'];
        switch(self::$_config['URL_MOD']){
            case 1:
                preg_match('/c=([a-zA-Z]+\w+)/', $query_str, $controller);
                preg_match('/a=([a-zA-Z]+\w+)/', $query_str, $action);
                $c = $controller[1] ? ucfirst($controller[1]) : self::$_config['D_C'];
                $a = $action[1] ? $action[1] : self::$_config['D_A'];
                break;
            case 2:
                $query_arr = explode('/', $query_str);
                $c = ucfirst($query_arr[1]);
                $a = $query_arr[2];
        }

        spl_autoload_register('\Framework\kernel::auto_load');
        $c .= 'Controller';
        try {
            $c_name = "\\App\\Controller\\" . $c;
            $obj = new $c_name;
            $reflectionMethod = new  \ReflectionMethod ($obj, $a);
            $reflectionMethod->invoke($obj, $a);
        } catch (exception $e) {
            exit('控制器不存在');
        }

    }


}




