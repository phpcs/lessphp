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
    	$obj = new \Framework\Model();
        var_dump($obj);
        $this->assign('a', '你好');
        $this->view('Index/index');
    }

}