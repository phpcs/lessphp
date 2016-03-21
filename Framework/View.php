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
        $this->view_path = ROOT. '/App/View/' . $file . '.html';
        unset($file);
        extract($this->value);
        include $this->view_path;
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