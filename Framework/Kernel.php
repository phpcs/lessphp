<?php
/**
 *
 * @author Bruce.cheng@carbit.com.cn
 * @date 16-2-18
 */
namespace Framework;

class Kernel
{
    public $module = 'Home';

    public function __construct()
    {
        // 设定错误和异常处理
        register_shutdown_function('\Framework\Kernel::fatalError');
        set_error_handler('\Framework\Kernel::appError');
        set_exception_handler('\Framework\Kernel::appException');
        spl_autoload_register('\Framework\Kernel::autoLoad');
        $this->start();
    }

    static public function autoLoad($classname)
    {
        if (stripos($classname, '\\')) {
            $str = str_replace('\\', '/', $classname);
        }
        includeFile(ROOT_PATH . $str . '.php');
    }

    public function start()
    {
        $filter_param = array('<', '>', '"', "'", '%3C', '%3E', '%22', '%27', '%3c', '%3e');
        $query_str = str_replace($filter_param, '', $_SERVER['REQUEST_URI']);
        $c = C('D_C');
        $a = C('D_A');
        switch (C('URL_MOD')) {
            case 1:     //传统模式
                preg_match('/c=([a-zA-Z]+\w+)/', $query_str, $controller);
                preg_match('/a=([a-zA-Z]+\w+)/', $query_str, $action);
                $c = isset($controller[1]) ? $controller[1] : C('D_C');
                $a = isset($action[1]) ? $action[1] : C('D_A');
                break;
            case 2:    //pathinfo模式
                if ($uri = self::_parse_request_uri()) {
                    $query_arr = explode('/', $uri);
                    $c = $query_arr[0];
                    if (count($query_arr) > 1) {
                        $a = $query_arr[1];
                        $_GET = array_slice($query_arr, 2);
                    }
                }
                //var_dump($_GET);
                break;
        }
        $c_name = "\\App\\Controller\\Home\\" . ucfirst($c) . C('C_NAME');
        if (class_exists($c_name)) {
            call_user_func(array(new $c_name, $a));
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

    // 致命错误捕获
    static public function fatalError()
    {
        if ($e = error_get_last()) {
            switch ($e['type']) {
                case E_ERROR:
                case E_PARSE:
                case E_CORE_ERROR:
                case E_COMPILE_ERROR:
                case E_USER_ERROR:
                    ob_end_clean();
                    halt('文件:' . basename($e['file']) . ' ,第' . $e['line'] . '行发生错误');
                    break;
            }
        }
    }

    /**
     * 自定义错误处理
     * @access public
     * @param int $errno 错误类型
     * @param string $errstr 错误信息
     * @param string $errfile 错误文件
     * @param int $errline 错误行数
     * @return void
     */
    static public function appError($errno, $errstr, $errfile, $errline)
    {
        halt('[文件:' . basename($errfile) . ' ,]第' . $errline . 'has error! ' . $errstr);
    }

    /**
     * 自定义异常处理
     * @access public
     * @param mixed $e 异常对象
     */
    static public function appException($e)
    {
        echo 3;
    }


    private function __clone()
    {
    }

}




