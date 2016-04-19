<?php
/**
 *
 * @author Bruce.cheng@carbit.com.cn
 * @date 16-2-18
 */
namespace App\Controller\Home;

class ProductController extends \Framework\Controller
{
    public function index()
    {
        $this->assign('title', 1111);
        $this->view();
    }
    public function test()
    {
        $this->assign('title', 1111);
        $this->view();
    }
}