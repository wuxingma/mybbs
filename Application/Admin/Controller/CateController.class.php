<?php
namespace Admin\Controller;

use Think\Controller;

class CateController extends Controller
{
    public function create()
    {
    	//获取所有分区
    	$parts = M('bbs_part')->select();
        //获取所有的用户名称
        $users = M('bbs_user')->where('auth<3')->select();
        // echo '<pre>';
        // print_r($parts);
        // print_r($users);die;
        $this->assign('parts',$parts);
    	$this->assign('users',$users);
    	$this->display();
    }
    public function save()
    {
    	
    	$row = M('bbs_cate') -> add($_POST);
    	// echo '<pre>';
    	// print_r($row);die;
    	if($row){
    		$this->success('添加板块成功');
    	} else {
    		$this -> error('添加板块失败');
    	}
    }

    public function index()
	{
		$condition=[];
		if(!empty($_GET['cname']) ){
			$condition['cname']=['like',"%{$_GET['cname']}%"];
		}
		$cates = M('bbs_cate')-> select();
		// echo '<pre>';
		// print_r($cates);die;
		// 获取分区信息
		$parts = M('bbs_part')->select();
		//[pid => 分区名称]
		$parts = array_column($parts,'pname','pid');

		//获取用户信息
		$users = M('bbs_user')->where($condition)->select();
		//[uid => 用户名称]
		$users = array_column($users,'uname','uid');
		$this->assign('cates',$cates);
		$this->assign('parts',$parts);
		$this->assign('users',$users);
		$this -> display();
    }

    public function del()
    {
        $cid = $_GET['cid'];
        $row = M('bbs_cate')->where( "cid=$cid" )->delete();
        if($row){
            $this->success('删除版主成功');
        } else {
            $this->error('删除版主不成功');
        }
    }

    public function edit()
    {
        $cid = $_GET['cid'];
        $cates = M('bbs_cate')->find($cid);

        $parts = M('bbs_part')->select();
        $users = M('bbs_user')->select();

        $this->assign('cates',$cates);
        $this->assign('parts',$parts);
        $this->assign('users',$users);
        $this->display();   
        
    }

    public function update()
    {
        $cid = $_GET['cid'];
        $row = M('bbs_cate')->where( "cid=$cid" )->save($_POST);
        if($row){
            $this->success('修改成功','./index.php?m=admin&c=cate&a=index');
        } else {
            $this->error('修改失败');
        }
    }
}
