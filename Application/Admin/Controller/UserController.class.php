<?php
namespace Admin\Controller;

use Think\Controller;
use Think\Image;

class UserController extends CommonController
{
    public function create()
    {
      

    	//显示create.html 文件
      	$this->display();
    }
    public function save()
    {
       
       $data = $_POST;
       //添加时间
       $data['created_at'] = time();
       //密码不能为空
       if(empty($data['upwd']) || empty($data['reupwd']) ){
            $this->error('密码不能为空');
       }
       // 密码不一致
       if($data['upwd'] !== $data['reupwd'] ){
            $this->error('密码不一致');
       }
       //加密密码
       $data['upwd'] = password_hash($data['upwd'],PASSWORD_DEFAULT);

        //拼接一个缩略图名称
        // $thumbName= $info['uface']['savepath'].'sm_'.$info['uface']['savename'];


        $data['uface']=$this->doUp();

    
        $this->doSm();

       //添加一个数据库返回一个受影响行数
       $row = M('bbs_user')->add($data);
       if($row){
            $this->success('用户添加成功');
       } else {
            $this->error('用户添加失败');
       }

    }
    public function index()
    {
      //定义一个空的数组
      $condition=[];
      //判断有没有性别条件 select * from bbs_usere where sex='w';
      if(!empty($_GET['sex'])){
         $condition['sex'] = ['eq',"{$_GET['sex']}"];
      }


      //判断有没有姓名条件 select * from bbs_user where uname like "%a%";
      if(!empty($_GET['uname'])){
        $condition['uname'] = ['like',"%{$_GET['uname']}%"];
      }
      //实例化一个对象
      $user = M('bbs_user');

       //查询满足要求的总记录数
      $count = $user->where($condition) -> count();
      //实例化一个分页类 传入总记录数每页显示的记录数(5)
      $Page = new \Think\Page($count,5);
      //得到分页显示html代码
      $html_page = $Page->show();
     
      //获取数据
      $users =$user -> where($condition)
                    -> limit($Page->firstRow, $Page->listRows)
                    -> select();
    
      //显示数据
      $this -> assign('users',$users);
      $this -> assign('html_page',$html_page);
      $this -> display();
      // echo '<pre>';
      // print_r($users);
    }
    public function del()
    {
      $uid = $_GET['uid'];

      $row = M('bbs_user')->delete($uid);
      if($row){
        $this->success('删除用户成功');
      } else {
        $this -> error('删除用户不成功');
      }
    }
   
   public function edit()
   {
      $uid = $_GET['uid'];
      $users = M('bbs_user')->find($uid);
      // echo '<pre>';
      // print_r($users);
      // die;
      $this->assign('users',$users);
      $this->display();
   }
   public function update()
   {
      $uid = $_GET['uid'];
      $data = $_POST;
      if(FILES['uface']['error']!==4){
        $data['uface']=$this->doUp();
        $this->doSm();
      }
      
      $row = M('bbs_user') -> where("uid=$uid") -> save($data);
     
      if($row){
        $this -> success('用户修改成功','/index.php?m=admin&c=user&a=index');
      } else {
        $this -> error('用户修改失败');
      }
   }

   //处理上传文件
   private function doUp()
   {

       //文件上传处理
        $config = [
          'maxSize' => 3145728,
          'rootPath' => './',
          'savePath' => 'Public/Uploads/',
          'saveName' => array('uniqid',''),
          'exts' => array('jpg', 'gif', 'png', 'jpeg'),
          'autoSub' => true,
          'subName' => array('date','Ymd'),

        ];
        $upload = new \Think\Upload($config);// 实例化上传类

        // 上传文件
        $info = $upload->upload();
        // echo '<pre>';
        // print_r($info);
        // die;
          
        if(!$info) {// 上传错误提示错误信息
          $this->error($upload->getError());
        }
        
        //拼接上传文件的完整路劲
        return $this->fileName = $info['uface']['savepath'].$info['uface']['savename'];
   }


   private function doSm()
   {
      //打开$fileName文件,后续进行处理
        $image = new Image(Image::IMAGE_GD,$this->fileName);
        

        $image->thumb(150,150)->save('./'.getSm($this->fileName));
   }
}
