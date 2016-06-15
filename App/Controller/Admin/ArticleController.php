<?php
/**
 *
 * @author Bruce.cheng@carbit.com.cn
 * @date 16-2-18
 */
namespace App\Controller\Admin;

use App\Controller\Admin;
use Illuminate\Support\Facades\DB;

class ArticleController extends FatherController
{

    public function index()
    {
        $sql = "SELECT * FROM article";
        $res = DB($sql);

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
        $id = $_GET['id'];
        $sql = "SELECT * FROM article WHERE id=" . $id;
        $res = DB($sql);

        $this->assign('list', $res[0]);
        $this->setTitle('修改日志');
        $this->view();
    }

    public function del()
    {
        $id = $_POST['id'];
        $data = ['status' => 0];
        if ($id) {
            $res = DB('del', 'article', $id);
            if ($res) {
                $data = ['status' => 1];
            }
        }

        $this->jsonEcho($data);
    }

    public function save()
    {
        $data = $this->getInput();
        if (!$data['id']) {
            $arr['title'] = $data['title'];
            $arr['content'] = $data['content'];
            $arr['cate_id'] = $data['cate'];
            $arr['create_time'] = NOW_DATE;
            $arr['update_time'] = NOW_DATE;
            $res = DB(array('save', 'article', $arr));
            if ($res) {
                echo json_encode(['code' => 'ok']);
            }
        } else {
            $insert_data = [$data['title'], $data['content'], $data['cate'], NOW_DATE];
            $res = DB(array('save', 'article', $insert_data));
            if ($res) {
                echo json_encode(['code' => 'ok']);
            }
        }
    }

}