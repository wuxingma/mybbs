<?php
namespace Admin\Controller;

use Think\Controller;

class IndexController extends Controller
{
    public function index()
    {
    	//显是某个html页面,默认为index.html
      	$this->display();
    }
}