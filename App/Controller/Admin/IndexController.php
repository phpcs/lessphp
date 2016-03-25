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
        echo '这是后台首页';
    }

    public function test()
    {
        echo __FILE__;
    }
}