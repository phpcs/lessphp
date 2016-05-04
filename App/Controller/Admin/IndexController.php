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
        $this->setTitle();
        $this->view();
    }

    public function panel()
    {
        $user = $_POST['user'];
        $pass = $_POST['password'];
        //if ($user=='admin' && $pass=='admin') {
        	$this->view();
        //}
    }
}