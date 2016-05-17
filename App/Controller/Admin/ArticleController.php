<?php
/**
 *
 * @author Bruce.cheng@carbit.com.cn
 * @date 16-2-18
 */
namespace App\Controller\Admin;

use App\Controller\Admin;

class ArticleController extends FatherController
{

    public function index()
    {
        $sql = "SELECT * FROM article";
        $res = DB()->query($sql);

        $this->assign('list', $res);
        $this->setTitle('日志列表');
        $this->view();
    }

    public function add()
    {
        $this->setTitle('添加日志');
        $this->view();
    }

    public function edit()
    {
        $this->setTitle('修改日志');
        $this->view();
    }

    public function save()
    {
        $data = $this->getInput();
        if ($data) {
            $sql = "INSERT INTO article VALUES(NULL, ?, ?, ?, ?, ?)";
            $insert_data = [$data['title'], $data['content'], $data['cate'], NOW_DATE, NOW_DATE];
            $res = DB()->insert($sql, $insert_data);
            if ($res) {
                echo json_encode(['code'=>'ok']);
            }
        }
    }

}