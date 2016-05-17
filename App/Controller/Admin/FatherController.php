<?php
/**
 *
 * @author Bruce.cheng@carbit.com.cn
 * @date 16-2-18
 */
namespace App\Controller\Admin;

class FatherController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        if ($_SESSION['login'] != 1) {
            header('location:/Admin/index');
        }
    }

    public function panel()
    {

        $this->view();
    }
}