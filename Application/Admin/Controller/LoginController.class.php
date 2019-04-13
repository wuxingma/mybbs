<?php
namespace Admin\Controller;

use Think\Controller;

class LoginController extends Controller
{
    public function login()
    {
    	$this->display();
    }
    public function dologin()
    {
    	// echo '<pre>';
    	// print_r($_POST);
    	$uname = $_POST['uname'];
    	$upwd = $_POST['upwd'];
    	$code = $_POST['code'];
    	$verify = new \Think\Verify();
		if( !$verify->check($code) ){
			$this->error('验证码不对');
		}

    	$user = M('bbs_user')->where( "uname='$uname'" )->find();
    	// var_dump($user);
    	if( $user && password_verify($upwd,$user['upwd']) ){
    		$_SESSION['userInfo'] = $user;
    		$_SESSION['flag'] = true;
    		$this->success('登录成功','/index.php?m=admin&c=index&a=index');
    	} else {
    		$this->error('登录失败');
    	}

    }
    public function logout()
    {
    	$_SESSION['userInfo'] = NULL;
    	$_SESSION['flag'] = false;
    	$this->success('正在退出...','/index.php?m=admin&c=login&a=login');
    }
    public function code()
    {
    	$config = array(
					'fontSize' => 17, // 验证码字体大小
					'length' => 3, // 验证码位数
					'useNoise' => false, // 关闭验证码杂点
					'useCurve' => false,
					'imageW' => 130,
					'imageH' => 35,
					);
		$Verify = new \Think\Verify($config);
		$Verify->entry();

    }
}