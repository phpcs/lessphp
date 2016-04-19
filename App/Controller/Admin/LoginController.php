<?php
/**
 *
 * @author Bruce.cheng@carbit.com.cn
 * @date 16-2-18
 */
namespace App\Controller\Admin;

class LoginController extends BaseController
{
    public function index()
    {
        $this->view();
    }

    public function test()
    {
        echo __FILE__;
    }
}