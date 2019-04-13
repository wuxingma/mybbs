<?php
namespace Admin\Controller;

use Think\Controller;

class CommonController extends Controller
{
    public function __construct()
    {
    	parent::__construct();
    	if( !$_SESSION['flag']){
    		$this->error('请你先登录','/index.php?m=admin&c=login&a=login');
    	}
    }
}