<?php
/**
 *
 * @author Bruce.cheng@carbit.com.cn
 * @date 16-2-18
 */
namespace App\Controller\Admin;

class IndexController extends BaseController
{
    public function index()
    {
        $this->assign('title','后台管理');
        $this->view();
    }

    public function test()
    {
        echo __FILE__;
    }
}