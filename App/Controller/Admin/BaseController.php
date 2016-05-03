<?php
/**
 *
 * @author Bruce.cheng@carbit.com.cn
 * @date 16-3-7
 */
namespace App\Controller\Admin;

class BaseController extends \Framework\Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function setTitle($title='LessPHP后台')
    {
        $this->assign('title', $title);
    }

}