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
        $this->assign('a', '你好');
        $this->assign('title', '测试标题');
        $this->view('Index/index');
    }

    public function test()
    {
        echo __FILE__;
    }
}