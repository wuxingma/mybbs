<?php
namespace Home\Controller;

use Think\Controller;

class PostController extends Controller
{
	public function create()
	{


		if( empty($_SESSION['flag']) ){
			$this->error('请你先登录','/index.php?m=home&c=login&a=signup');
		}

		//获取板块信息
		$cates = M('bbs_cate')->getField('cid,cname');
		
		$this->assign('cates',$cates);
		$this->display();
	}

	public function save()
	{
		// echo '<pre>';
		// print_r($_POST);
		$data = $_POST;
		//获取发帖人
		$data['uid'] = $_SESSION['userInfo']['uid'];
		$data['updated_at'] = $data['created_at'] = time();
		$row = M('bbs_post')->add($data);
		if($row){
			$this->success('发帖成功');
		} else {
			$this->error('发帖失败');
		}
		
	}

	public function index()
	{
		$cid=empty($_GET['cid']) ? 1 : $_GET['cid'];
		// echo '<pre>';
		// print_r($cid);
		
		//获取数据
		$posts = M('bbs_post')->where("cid='$cid'")->order('updated_at desc')->select();
		// echo '<pre>';
		// print_r($posts);
		$uid = $_SESSION['userInfo']['uid'];
		

		$users = M('bbs_user')->where("uid='$uid'")->getField('uid,uname');
		// print_r($users);die;

		//遍历显示
		$this->assign('posts',$posts);
		$this->assign('users',$users);
		$this->display();
	}
}