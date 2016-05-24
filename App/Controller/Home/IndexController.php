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
        $sql  = "select id,content from article order by id desc limit 0,10 ";
        $res = DB()->query($sql);
        $this->assign('list', $res);
        $this->view('Index/index');
    }

    /**
     * 抓去陈杰博客
     */
    public function getArticle()
    {

        for ($i=1717; $i <= 1730; $i++) {
            $res = file_get_contents("http://www.chenjie.info/".$i);
            if ($res) {
                preg_match('#<h1\s+class=\"entry-title\">(.*)<\/h1>#s', $res, $arr);
                $title = $arr[1];
                preg_match('#<div\s+class=\"entry-content\s+clearfix\">(.*?)<footer\s+class="entry-footer">#s', $res, $arr_content);
                $content = $arr_content[1];
                preg_match('#<a\s+href=\"http://www.chenjie.info/category/(\w+)\">(.*?)<#si', $res, $arr_tag);
                $cate = $arr_tag[2];

                $sql = "INSERT INTO article VALUES(NULL, ?, ?, date('Y-m-d H:i:s'), 0, ?)";

                $id = DB()->insert($sql, array($title, addslashes($content), $cate));
                if ($id) {
                    echo '抓取成功,文章id:' . $i . ',数据表id:' . $id;
                    echo "<br/>";
                } else {
                    echo '<hr>';
                    echo '失败:' . $i;
                }
            }
        }
    }


}