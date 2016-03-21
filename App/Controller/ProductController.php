<?php
/**
 *
 * @author Bruce.cheng@carbit.com.cn
 * @date 16-2-18
 */
namespace App\Controller;

class ProductController extends \Framework\Controller
{

    public function test()
    {
        $this->assign('title', 1111);
        $this->view('Product/test');
    }
}