<?php
namespace Admin\Controller;
use Think\Controller;
class AdminsController extends Controller{	


//管理员登录
	public function login(){	
		if(IS_POST){	
			$administratorTabModel = M('administrator');
			$condition = array(	
				'adm_username' => I("post.username"),
				'adm_password' => I("post.password")
				);
			$result = $administratorTabModel->where($condition)->count();
			if($result>0){	
				session("adm_username",I("post.username"));
				$this->success("欢迎回来~",U("videos/index"));
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
	public function register(){	
		$this->display();
	}

//注册为管理员

	public function doReg(){	
		if(!IS_POST){	
			exit("bad request!");
		}
		$administratorTabModel=M("administrator");
		$condition = array(	
				'adm_username' => I("post.username"),
				'adm_password' => I("post.password")
				);
		$condition1 = $condition['adm_username'];

		$result = $administratorTabModel->select();
		foreach ($result as $key => $value) {
			if($value['adm_username']==$condition1){	
				$this->error("该用户已注册！");
			}
		}
		$administratorTabModel->data($condition)->add();
		session("adm_username",I("post.username"));
		$this->success("恭喜你，注册成功！",U("videos/index"));

		
		
	}

//退出管理员登录

	public function logout(){	
		session('[destroy]');
		$this->display();
		redirect(U('Admin/admins/login'),2,' ');
	}
	

}

?>