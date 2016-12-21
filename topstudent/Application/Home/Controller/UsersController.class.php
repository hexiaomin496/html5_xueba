<?php
namespace Home\Controller;
use Think\Controller;
class UsersController extends Controller {
   
    //管理员登录
	public function login(){	
		if(IS_POST){	
			$userTabModel = M('usertab');
			$condition = array(	
				'user_username' => I("post.username"),
				'user_password' => I("post.password")
				);
			$result = $userTabModel->where($condition)->count();
			$id = $userTabModel->where($condition)->field('user_id')->select();
			$ids = $id[0];
			//var_dump($ids);
			if($result>0){	
				session("user_username",I("post.username"));
				session("id",$ids);
				$idss = $_SESSION['id'];
				//var_dump($idss);
				$this->success("欢迎回来~",U("personal/index"));
				//$idss = $_SESSION['id'];
    			//var_dump($idss);
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
		$id = $user->where($condition)->find();
		$ids = $id['user_id'];
		session("user_username",I("post.username"));
		session("id",$ids);
		$this->success("注册成功",U("personal/index"));

		
		
	}

	//退出登录

	public function logout(){	
		session('[destroy]');
		//$this->display();
		redirect(U('users/login'),2,'exit...');
	}
	
	
}