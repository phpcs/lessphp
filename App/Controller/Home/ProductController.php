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
        $sql = "SELECT * FROM article";
        $res = DB()->query($sql);
        $this->assign('list', $res);
        $this->view();
    }

    public function info()
    {
        $article_id = $_GET['id'];
        $sql = "SELECT * FROM article WHERE id=".$article_id;
        $res = DB()->query($sql);

        $info['content'] = stripslashes($res[0]['content']);
        $info ['title'] = $res[0]['title'];
        $info ['cate'] = $res[0]['cate'];
        $this->assign('info', $info);
        $this->view();
    }
}