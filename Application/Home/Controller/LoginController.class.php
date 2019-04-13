<?php
namespace Home\Controller;

use Think\Controller;

class LoginController extends Controller
{
	public function signup()
	{
		$this->display();
	}
	//接受数据,保存到数据库
	public function register()
	{
		// echo '<pre>';
		// print_r($_POST);
		$data = $_POST;
		$data['created_at'] = time();
		if(empty($data['upwd']) || empty($data['reupwd']) ){
			$this->error('密码不能为空');
		}
		if($data['upwd'] !== $data['reupwd']){
			$this->error('密码不一致');
		}
		$data['upwd'] = password_hash($data['upwd'],PASSWORD_DEFAULT);

		$n = preg_match('/^1[3-9]\d{9}$/', $data['tel']);
    	if (!$n) {
        	die('手机号码不符号要求!');
    	}
        $row = M('bbs_user')->add($data);
        if($row){
        	$this->success('注册成功','/');
        } else {
        	$this->error('注册失败');
        }
	}

	public function dologin()
	{
		// echo '<pre>';
		// print_r($_POST);

		$uname = $_POST['uname'];
		$upwd = $_POST['upwd'];
		$user = M('bbs_user')->where("uname='$uname'")->find();
		if( $user && password_verify($upwd,$user['upwd']) ){
			$_SESSION['userInfo'] = $user;

			$_SESSION['flag'] = true;
			$this->success('登录成功','/');
		} else {
			$this->error('账号或密码错误');
		}
	}


	public function logout()
	{
		$_SESSION['userInfo'] = null;
		$_SESSION['flag'] = false;
		if(empty($_SESSION['flag']) ){
			$this->success('正在退出~~','/');
		}
	}
}