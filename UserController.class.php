<?php
namespace Admin\Controller;
use Think\Controller;
class UserController extends Controller{

//管理员登录
	public function login(){
		if(IS_POST){
			$administratorTabModel = M('administratortab');
			$condition = array(
				'username' => I("post.username");
				'password' => I("post.password");
				);
			$result = $administratorTabModel->where($condition)->count();
			if($result>0){
				session("username",I("post.username"));
				$this->success("登录成功",U("Index/index"));
			}
			else{
				$this->error("用户名或密码不正确");
			}
		}
		else{
			$this->display();
		}
	}

//注册
	public function reg(){
		$this->display();
	}

//注册为管理员

	public function doReg(){
		if(!IS_POST){
			exit("bad request!");
		}
		$administratorTabModel=D("administratortab");
		$condition = array(
				'username' => I("post.username");
				);
		$result = $administratorTabModel->where($condition)->count();
		if($result==0 && $administratorTabModel->add()){
			$this->success("注册成功",U("lists"));
		}
		elseif ($result>0) {
			$this->error("用户名已使用");
		}
		else{
			$this->error("注册失败");
		}
	}

//退出管理员登录

	public function logout(){
		session('[destroy]');
		redirect(U('User/login'),2,'正在退出');
	}
	public function doAdd(){
		if(!IS_POST){
			exit("bad request请求");
		}

	}

}

?>