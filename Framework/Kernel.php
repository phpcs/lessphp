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
        if (C('WEB_STATUS') == 0) {
            closed();
        }
    }

    /**
     * 根据处理后的request_uri获取分段参数
     */
    public static function start()
    {
        // 设定错误和异常处理
        spl_autoload_register('\Framework\Kernel::autoLoad');

        register_shutdown_function('\Framework\Kernel::fatalError');
        set_error_handler('\Framework\Kernel::appError');
        set_exception_handler('\Framework\Kernel::appException');
        switch (C('URL_MOD')) {
            case 1:     //传统模式
                self::tradition_uri();
                break;
            default :       //pathinfo模式
                self::pathinfo_url();
        }
    }

    public static function tradition_uri()
    {
        define('GROUP', isset($_GET['g']) ? $_GET['g'] : C('DEFAULT_GROUP'));
        define('CONTROLLER', $_GET['c']);
        define('ACTION', $_GET['a']);
    }

    public static function pathinfo_url()
    {
        if (strpos($_SERVER['REQUEST_URI'], 'static') || strpos($_SERVER['REQUEST_URI'], 'static')){
            includeFile(ROOT_PATH.$_SERVER['REQUEST_URI']);
            return ;
        }

        $query_arr = explode(C('SEPARATER'), trim($_SERVER['REQUEST_URI'], '/'));
        define('GROUP', ( in_array(ucfirst($query_arr[0]), C('GROUP_LIST')) && (ucfirst($query_arr[0])!=C('DEFAULT_GROUP')) )? $query_arr[0] : 'Home' );
        if (GROUP != C('DEFAULT_GROUP')) {
            array_shift($query_arr);
        }

        define('CONTROLLER', $query_arr[0] ? ucfirst($query_arr[0]) : C('DEFAULT_CONTROLLER'));

        array_shift($query_arr);
        define('ACTION', $query_arr[0] ?: C('DEFAULT_ACTION'));

        array_shift($query_arr);
        for($i=0, $j=count($query_arr)-1 ; $i<$j ; $i++){
            $_GET[$query_arr[$i]] = $query_arr[$i+1];
            $i++;
        }
        $s_controller =  '\\'. APP_NAME . "\\Controller\\" . GROUP . "\\" . CONTROLLER .Controller;
        if (!class_exists($s_controller)){
            echo $s_controller . '控制器不存在';
            exit;
        }

        $obj_conrtroller = new $s_controller;

        if (!method_exists($obj_conrtroller, ACTION)) {
            echo ACTION . '方法不存在';
            exit;
        }

        call_user_func(array($obj_conrtroller, ACTION));

    }

    static public function autoLoad($classname)
    {
        if (strpos($classname , 'Framework') !==false) {
            if (strpos($classname, 'lib') !==false){
                $classname = ltrim(strrchr($classname, '\\'), '\\');
                $file_path = CORE . 'lib' . DS . '' . $classname . __EXT__;
            } else {
                $classname = trim(strrchr($classname, '\\'), '\\');
                $file_path = CORE  . $classname . __EXT__;
            }
        } elseif (substr($classname,-10)=='Controller') {
            $classname = trim(strrchr($classname, '\\'), '\\');
            $file_path = C_PATH . GROUP . DS . $classname . __EXT__;
        }
        includeFile($file_path);
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




