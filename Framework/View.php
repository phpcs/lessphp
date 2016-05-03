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
        if (empty($file)) {
            $file = Module_CONTROLLER.DS.Module_ACTION;
        }
        $this->view_path = APP_PATH . 'View' . DS . Module_GROUP . DS . $file . '.html';
        unset($file);
        extract($this->value);
        $content = file_get_contents($this->view_path);
        $this->parseTemplate($content);
    }

    public function parseTemplate($content)
    {
        preg_match_all('#<include\s+file=\s?(\"|\')\s?(.*?)\s?(\"|\')\s+/>#', $content, $arr);
        foreach ($arr[2] as $k => $v) {
            $s_include = file_get_contents(APP_PATH . 'View' . DS . Module_GROUP . DS . 'Base' . DS . $v);
            $content  = str_replace($arr[0][$k], $s_include, $content);
        }
        $cache_file = APP_PATH. 'Cache/'.md5(Module_CONTROLLER.DS.Module_ACTION).'.php';
        $content = preg_replace('#\{\$([a-zA-Z]+)\}#', '<?php echo \$this->value[\'\\1\']; ?>', $content);

        file_put_contents($cache_file, $content);

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