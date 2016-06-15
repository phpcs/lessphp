<?php
/**
 *
 * @author Bruce.cheng@carbit.com.cn
 * @date 16-3-21
 */
namespace Framework;

class View
{
    protected $value = [];

    protected $view_path;

    protected $view_dir = '';

    /**
     * 输出视图
     *
     * @param $file
     */
    public function view($file)
    {
        $this->view_dir  = V_PATH . GROUP . DS;
        if (empty($file)) {
            $file = CONTROLLER . DS . ACTION;
        }
        $this->view_path = $this->view_dir . $file . '.html';
        unset($file);
        extract($this->value);
        $content = file_get_contents($this->view_path);
        $this->parseTemplate($content);
    }

    /**
     * @param $content
     */
    public function replaceTemplate($content)
    {
        preg_match_all('#<include\s+file=\s?(\"|\')\s?(.*?)\s?(\"|\')\s+/>#', $content, $arr);
        if ($arr) {
            foreach ($arr[2] as $k => $v) {
                $s_include = file_get_contents($this->view_dir . 'Base' . DS . $v);
                $content = str_replace($arr[0][$k], $s_include, $content);

            }
        }
        return $content;
    }

    public function parseTemplate($content)
    {
        /*if (preg_match('#\{\$([a-zA-Z]+)\}#', $content)) {
            $content = preg_replace('#\{\$([a-zA-Z]+)\}#', '<?php echo \$this->value[\'\\1\']; ?>', $content);
       } */
        extract($this->value);
        $cache_file = APP_PATH. 'Cache'. DS . GROUP . DS . md5($content).'.php';
        if ( C('DEBUG') ) {
            if (C('LAYOUT') && ( strpos($content,'__NO_LAYOUT__')===false)) {
                $layout = file_get_contents($this->view_dir . 'layout.html');
                $content = str_replace('__CONTENT__', $content, $layout);
            } else {
                $content = str_replace('__NO_LAYOUT__', '', $content);
            }

            $content = $this->replaceTemplate($content);
            file_put_contents($cache_file, $content);
        }

        /**
         * 框架运行时间
         */
        $time_end = calcTime(microtime());
        $time_start = calcTime($GLOBALS['START_TIME']);
        define('SPEND_TIME', $time_end-$time_start);

        include $cache_file;

    }

    /**
     * 模板变量赋值
     *
     * @param $key
     * @param $value
     */
    public function assign($key, $value)
    {
        $this->value[$key] = $value;
    }
}