<?php
namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{
    public function index()
    {
    	//获取分区
      	
      	$parts = M('bbs_part')->select();
      	$parts = array_column($parts,null,'pid');

      	//获取板块
      	$cates = M('bbs_cate')->select();

      	//把板块信息追加到分区中去
      	foreach($cates as $cate){
      		$parts[$cate['pid']]['sub'][]=$cate;
      	}

      	// echo '<pre>';
      	// print_r($parts);
      	// print_r($cates);die;
      	$this->assign('parts',$parts);
        $this->display();
    }
}