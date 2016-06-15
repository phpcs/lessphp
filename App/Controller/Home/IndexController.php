<?php
/**
 *
 * @author Bruce.cheng@carbit.com.cn
 * @date 16-2-18
 */
namespace App\Controller\Home;


class IndexController extends  BaseController
{

    public function index()
    {
        $sql  = "select id,content,title from article order by id desc limit 0,10 ";
        $res = DB($sql);
        $this->assign('list', $res);

        $this->view();
    }

    public function test()
    {
        echo __METHOD__;
    }




}