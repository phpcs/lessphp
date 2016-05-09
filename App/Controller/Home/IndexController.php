<?php
/**
 *
 * @author Bruce.cheng@carbit.com.cn
 * @date 16-2-18
 */
namespace App\Controller\Home;

use Framework\Db;

class IndexController extends BaseController
{
    public function index()
    {
        $db  = Db::getInstance();
        var_dump($db);
        $this->assign('a', '你好');
        $this->view('Index/index');
    }

}