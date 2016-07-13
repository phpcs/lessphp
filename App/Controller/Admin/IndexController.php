<?php
/**
 *
 * @author Bruce.cheng@carbit.com.cn
 * @date 16-2-18
 */
namespace App\Controller\Admin;

class IndexController extends BaseController
{
    public function index()
    {
        if (IS_AJAX) {
            $user = $_POST['user'];
            $pass = $_POST['password'];
            $code = $_POST['verify_code'];
            if ($user == C('USER_NAME') && $pass == c('USER_PASS') && ($code==$_SESSION['captcha_code'])) {
                $_SESSION['login']=1;
                $this->jsonEcho(['code' => 1, 'mes' => 'success']);
            } else {
                var_dump($code);
                var_dump($_SESSION['captcha_code']);
                $this->jsonEcho(['code' => 0, 'mes' => 'fail']);
            }
        }
        
        $this->setTitle('欢迎登陆');
        $this->view();
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header('location:/Admin/index');
    }

    public function getCodePut(){
        $code = new \Framework\lib\code();
        $code->create();
    }

}