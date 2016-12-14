<?php
namespace Home\Controller;
use Think\Controller;

class UsersController extends Controller{	
	public function login(){	
		if(IS_POST){	
			$usertab = M('usertab');
			$condition = array(	
				'user_username' => I("post.username"),
				'user_password' => I("post.password")
				);
			
			$result = $usertab->where($condition)->count();
			$z = $usertab->where($condition)->find();
			$a = $z['user_id'];
			
			if($result>0){	
				session("user_username",I("post.username"));
				session("userid",$a);
				$this->success("欢迎回来~",U("personal/index"));
			}
			else{	
				$this->error("用户名或密码不正确");
			}
		}
		else{	
			$this->display();
		}
	}

	public function register(){	
		$this->display();
	}

	public function doReg(){	
		if(!IS_POST){	
			exit("bad request!");
		}
		$user=M("usertab");
		$condition = array(	
				'user_username' => I("post.username"),
				'user_password' => I("post.password")
				);
		$condition1 = $condition['user_username'];

		$result = $user->select();
		foreach ($result as $key => $value) {
			if($value['user_username']==$condition1){	
				$this->error("该用户已注册！");
			}
		}
		$user->data($condition)->add();
		$z = $user->where($condition)->find();
		$a = $z['user_id'];
		session("user_username",I("post.username"));
		session("userid",$a);
		$this->success("注册成功",U("personal/index"));

		
		
	}

	//退出登录

	public function logout(){	
		session('[destroy]');
		//$this->display();
		redirect(U('login'),2,'正在退出...');
	}
	




}
?>