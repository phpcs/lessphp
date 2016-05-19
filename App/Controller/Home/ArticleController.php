<?php
/**
 *
 * @author Bruce.cheng@carbit.com.cn
 * @date 16-2-18
 */
namespace App\Controller\Home;

class ArticleController extends \Framework\Controller
{
    public function index()
    {
        $sql = "SELECT * FROM article";
        $res = DB()->query($sql);
        foreach ($res as $k => &$v) {
            $v['time'] = $this->getTime($v['update_time']);
        }
        $this->assign('list', $res);
        $this->view();
    }

    public function info()
    {
        $article_id = $_GET['id'];
        $sql = "SELECT * FROM article WHERE id=" . $article_id;
        $res = DB()->query($sql);

        $info['content'] = stripslashes($res[0]['content']);
        $info ['title'] = $res[0]['title'];
        $info ['cate'] = $res[0]['cate_id'];
        $this->assign('info', $info);
        $this->view();
    }

    private function getTime($update_time)
    {
        $res = $update_time;
        $date_time = strtotime($update_time);
        $now_time = time();
        $arr = [strtotime(date('Y-m-d') . ' 00:00:00'), strtotime(date('Y-m-d') . ' 23:59:59')];
        if ( ($now_time >= $arr[0]) && ($now_time <= $arr[1])) {
            $over = $now_time - $date_time;
            if ($over<60) {
                $res = $over. '秒前';
            } elseif($over>60 && $over<3600) {
                $res = ceil($over%60). '分钟前';
            } else {
                $res = ceil($over/3600). '小时前';
            }
        }

        return $res;
    }
}