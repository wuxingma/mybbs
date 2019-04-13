<?php
namespace Admin\Controller;

use Think\Controller;

class PartController extends CommonController
{
   //添加分区-表单
   public function create()
   {
   		$this->display();//view/part/create.html
   }

   //添加分区-接受数据保存
   public function save()
   {
   
      try{
         $row=M('bbs_part')->add($_POST);
      
      } catch(\Exception $e){
         $this->error('分区已存在');
      }
      
    
    
      if($row){
            $this->success('添加分区成功');
         } else {
            $this->error('添加分区失败');
         }
   }

   //查看所有分区
   public function index()
   {
   		$parts = M('bbs_part')->select();
   		$this->assign('parts',$parts);
   		$this->display();
   }

   //删除分区
   public function del()
   {
   		$pid=$_GET['pid'];
   		$row = M('bbs_part')->delete($pid);
   		if($row){
   			$this->success('删除分区成功','./index.php?m=admin&c=part&a=index');
   		} else {
   			$this->error('删除分区失败');
   		}
   }

   //修改分区-显示原有数据
   public function edit()
   {
   		$pid = $_GET['pid'];
   		$parts = M('bbs_part')->where('cid<3')->find($pid);
   		$this->assign('parts',$parts);
   		$this->display();
   }

   //修改数据-接收修改后数据,更新
   public function update()
   {
   		$pid = $_GET['pid'];
   		$row = M('bbs_part')->where("pid=$pid")->save($_POST);
   		if($row){
   			$this->success('修改分区成功');
   		} else {
   			$this->error('修改分区失败');
   		}
   }
    
}