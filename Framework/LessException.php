<?php
/**
 * Created by PhpStorm.
 * User: chengshuo
 * Date: 16-7-13
 * Time: 上午11:38
 */
namespace Framework;

final class LessException extends \Exception
{
    protected $code;

    protected $mes;

    protected $trace;


    public function __construct($e)
    {
        $this->code = $e->getCode();
        $this->mes = $e->getMessage();
        $this->trace = $e->getTrace();
    }

    /**
     * 异常输出 所有异常处理类均通过__toString方法输出错误
     * 每次异常都会写入系统日志
     * 该方法可以被子类重载
     * @access public
     * @return array
     */
    public function __toString()
    {
        if ($this->code==1){
            $traceInfo = '';
            $time = date('y-m-d H:i:m');
            echo '<pre>';
            foreach ($this->trace as $t) {
                if (isset($t['file'])) {
                    $traceInfo .= '[' . $time . '] ' . $t['file'] . ' (' . $t['line'] . ') ';
                    if (isset($t['class'])) {
                        $traceInfo .= $t['class'] . $t['type'] . $t['function'];
                    }
                    $traceInfo .= "\n<hr/>";
                }
            }

        }

        return "<b>".$this->mes."\n</b>" . '<br/>' . $traceInfo;
    }

}