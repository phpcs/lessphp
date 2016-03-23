<?php
/**
 *
 * @author Bruce.cheng@carbit.com.cn
 * @date 16-2-18
 */
namespace App\Controller\Home;

class IndexController extends BaseController
{
    public function index()
    {
        $this->view('Index/index');
        $this->assign('a', 123);
    }

    public function test()
    {
        echo __FILE__;
    }
}