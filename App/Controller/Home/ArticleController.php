<?php
/**
 *
 * @author Bruce.cheng@carbit.com.cn
 * @date 16-2-18
 */
namespace App\Controller\Home;

class ArticleController
{
    public function index()
    {
        echo 'Article';
        exit;
        $sql = "SELECT * FROM article";
        $res = DB($sql);
        foreach ($res as $k => &$v) {
            $v['time'] = $this->getTime($v['update_time']);
        }
        $this->assign('list', $res);
        $this->view();
    }

    private function getTime($update_time)
    {

        $month = substr($update_time, 5, 2);
        $day = substr($update_time, 8, 2);

        $now_month = date('m');
        $now_day = date('d');

        if ($month == $now_month) {
            $day_over = $now_day - $day;
            switch($day_over) {
                case 0:
                    $res = '今天';
                    break;
                case 1:
                    $res = '昨天';
                    break;
                case 2:
                    $res = '前天';
                    break;
                default:
                    $res = substr($update_time, 0, 10);
            }
        }else{
            $res = $update_time;
        }

        return $res;
    }

    public function info()
    {
        $article_id = $_GET['id'];
        $sql = "SELECT * FROM article WHERE id=" . $article_id;
        $res = DB($sql);

        $info['content'] = stripslashes($res[0]['content']);
        $info ['title'] = $res[0]['title'];
        $info ['cate'] = $res[0]['cate_id'];
        $this->assign('info', $info);
        $this->view();
    }
}