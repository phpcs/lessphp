<?php
/**
 *
 * @author Bruce.cheng@carbit.com.cn
 * @date 16-3-21
 */
namespace Framework;

class Controller
{

    protected $view;

    public function __construct()
    {
        $this->view =  new View();
    }

    public function view($file='')
    {
        $this->view->view($file);
    }

    public function assign($key, $value)
    {
        $this->view->assign($key, $value);
    }

    public function __call($name, $args)
    {
        halt();
    }
}