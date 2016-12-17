<?php
   namespace Admin\Controller;
   use Think\Controller;
   class IndexController extends Controller{
   		public function __construct(){
   		
   			parent::__construct();
   			$this->success("欢迎来到后台，请先登录",U("Admin/admins/login"));
   	
   		}
   		public function index(){	

   		}
   }
?>