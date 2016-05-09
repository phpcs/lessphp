<?php
/**
 *
 * @author Bruce.cheng@carbit.com.cn
 * @date 16-2-18
 */
namespace Framework;

class Kernel
{

    public function __construct()
    {
        $this->g = C('D_G_F');
        $this->c = C('D_C');
        $this->a = C('D_A');
        // 设定错误和异常处理
        register_shutdown_function('\Framework\Kernel::fatalError');
        set_error_handler('\Framework\Kernel::appError');
        set_exception_handler('\Framework\Kernel::appException');
        spl_autoload_register('\Framework\Kernel::autoLoad');
        $this->start();
    }

    /**
     * 根据处理后的request_uri获取分段参数
     */
    public function start()
    {
        if (C('WEB_STATUS') == 0) {
            closed();
        }
        switch (C('URL_MOD')) {
            case 1:     //传统模式
                $this->tradition_uri();
                break;
            default :       //pathinfo模式
                $this->pathinfo_url();
        }
        $c_name = "\\" . APP_NAME . "\\Controller\\" . $this->g . "\\" . ucfirst($this->c) . C('D_C_NAME');
        define('Module_GROUP',ucfirst($this->g));
        define('Module_CONTROLLER',ucfirst($this->c));
        define('Module_ACTION',$this->a);
        if (class_exists($c_name)) {
            call_user_func(array(new $c_name, $this->a));
        }
    }

    public function tradition_uri()
    {
        $this->g = isset($_GET['g']) ? $_GET['g'] : C('D_G_F');
        $this->c = $_GET['c'];
        $this->a = $_GET['a'];
    }

    public function pathinfo_url()
    {
        if (strpos($_SERVER['REQUEST_URI'], 'static') || strpos($_SERVER['REQUEST_URI'], 'static')){
            includeFile(ROOT_PATH.$_SERVER['REQUEST_URI']);
            return ;
        }
        if ($uri = self::_parse_request_uri()) {
            $query_arr = explode(C('SEPARATER'), $uri);
            if (in_array($query_arr[0], C('GROUP_LIST'))) {
                $this->g = $query_arr[0];
                array_shift($query_arr);
            }
            $_length = count($query_arr);
            if (!empty($query_arr)&& $_length < 2) {
                $this->c = $query_arr[0];
            } elseif(!empty($query_arr)&& $_length >= 2) {
                $this->c = $query_arr[0];
                $this->a = $query_arr[1];
                $_arr = array_slice($query_arr, 2);
                if ($_length>2) {
                    for ($i = 0, $j = count($_arr); $i < $j; $i++) {
                        if (even($i)) {
                            if (isset($_arr[$i + 1])) {
                                $_GET[$_arr[$i]] = $_arr[$i + 1];
                            } else {
                                $_GET[$_arr[$i]] = '';
                            }
                        }
                    }
                }
            }
            unset($_GET['s']);
        }
    }

    /**
     * 处理request_uri
     *
     * @return string
     */
    static public function _parse_request_uri()
    {
        if (!isset($_SERVER['REQUEST_URI'], $_SERVER['SCRIPT_NAME'])) {
            return '';
        }
        $filter_param = array('<', '>', '"', "'", '%3C', '%3E', '%22', '%27', '%3c', '%3e');
        $query_str = str_replace($filter_param, '', $_SERVER['REQUEST_URI']);

        $uri = parse_url('http://dummy' . $query_str);
        $uri = isset($uri['path']) ? $uri['path'] : '';

        if (strpos($uri, $_SERVER['SCRIPT_NAME']) === 0) {
            $uri = (string)substr($uri, strlen($_SERVER['SCRIPT_NAME']));
        } elseif (strpos($uri, dirname($_SERVER['SCRIPT_NAME'])) === 0) {
            $uri = (string)substr($uri, strlen(dirname($_SERVER['SCRIPT_NAME'])));
        }

        return trim($uri, '/');
    }

    static public function autoLoad($classname)
    {
        if (stripos($classname, '\\')) {
            $str = str_replace('\\', '/', $classname);
        }
        includeFile(ROOT_PATH . $str . '.php');
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
                    halt('文件:' . $e['file'] . ' ,第' . $e['line'] . '行发生错误');
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
        //var_dump(222);

        //$error = '[文件:' . basename($errfile) . ' ,]第' . $errline . 'has error! ' . $errstr;
        //echo $error;
    }

    /**
     * 自定义异常处理
     * @access public
     * @param mixed $e 异常对象
     */
    static public function appException($e)
    {
        p($e);
    }

    private function __clone()
    {
    }

}




