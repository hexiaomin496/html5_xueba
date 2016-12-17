<?php

namespace Admin\Controller;
use Think\Controller;
session_start();
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
      $data=$administratorTabModel->where($condition)->find();

			if($result>0){	
        $_SESSION['adm_username']=I("post.username");
        $_SESSION['userstatus']=$data['adm_status'];
        $_SESSION['userid']=$data['adm_id'];
				// session("adm_username",I("post.username"));
    //     session("userstatus",$data['adm_status']);
        
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

//遍历
	public function index(){
        //判断管理员是否为超级管理员
        $userstatus=$_SESSION['userstatus'];
        if ($userstatus != 1 || $userstatus == '') {
           $this->error("您不是超级管理员，无法访问该页面");
        }
        
		    $Model = M('administrator'); // 实例化对象
        $result=$Model->select();
        $this->assign('user',$result);
        $count = $Model->count();// 查询满足要求的总记录数
     
        $Page = new \Think\Page($count,4);// 实例化分页类 传入总记录数和每页显示的记录数(25)

        $Page->setConfig('header','<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('last','末页');
        $Page->setConfig('first','首页');
        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');

       $show = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
       $list = $Model->order('adm_id')->limit($Page->firstRow.','.$Page->listRows)->select();
    
       $this->assign('list',$list);// 赋值数据集
      
       $this->assign('page',$show);// 赋值分页输出

       $this->display();
     
	}

//添加管理员

	public function add(){
       //判断管理员是否为超级管理员
        $userstatus=$_SESSION['userstatus'];
        if ($userstatus != 1 || $userstatus == '') {
           $this->error("您不是超级管理员，无法访问该页面");
        }
    	  $this->display();
    }

    public function doAdd(){
    	if(!IS_POST){
    		exit("bad request!");
    	}
        $userModel = D("administrator");
        if (!$userModel->create()) {
        	$this->error($userModel->getError());
        }
        if($userModel->add()){
        	$this->success("添加成功",U("index"));
        }
        else{
        	$this->error("添加失败！");
        }

    } 
    
 //修改管理员密码
    public function edit(){
    $id=$_SESSION['userid'];
		$user=M("administrator")->find($id);
   
		$this->assign("user",$user);
		$this->display();
	}

	public function doEdit(){
		if(!IS_POST){
			exit("bad request!");
		}
		$userModel=D("administrator");
		if(!$userModel->create()){
			$this->error($userModel->getError());
		}
		if($userModel->save()){
			$this->success("修改成功！",U("index"));
		}
		else{
			$this->error("修改失败！");
		}
	}
   //编辑管理员信息
	public function modi(){
		$id = intval(I('get.id'));
		
		if ($id == '') exit("bad param");
		
		$user=M("administrator")->find($id);

		$this->assign("user",$user);
		$this->display();
	}

	public function doModi(){
		if(!IS_POST){
			exit("bad request!");
		}else{
		$userModel=M("administrator");
		$userModel->create();

		if($userModel->save()){

			$this->success("修改成功！",U("index"));
		}
		else{
			$this->error("修改失败！");
		}
	     }
	}

	//删除单个管理员
	public function delete(){
       $id = intval(I('get.id'));
       if ($id == '') exit("bad param");

        if(is_array($id)){
            foreach($id as $value){
                M("administrator")->delete($value);
            }  
            $this->success("删除成功！");
        } 
        else{
            if(M("administrator")->delete($id)){
                $this->success("删除成功！");
            }
        }       
    }
    //全选删除管理员
     public function deleteAll(){	
       		$Model = M('administrator');
       		$id = $_GET['id'];
       		$i=0;
       		foreach ($id as $key => $value) {
       			$it=$value;
       			//$it=(int)$it;
       			$where = 'adm_id='.$it;
       			$list[$i]=$Model->where($where)->delete();
       			$i++;
       		}
       		
       		  
       		if($list){	
       			$this->success("成功删除{$i}条",U('index'));
       		}
       		else{	
       			$this->error('删除失败');
       		}
       }

   //搜索管理员

    public function searchAdmin()
    {
        import('Org.Util.Page');
        $username = $_GET['admin_name'];
        $userModel = M('administrator');
        $condition['adm_username'] = array('like','%'.$username.'%');
        $count = $userModel->where($condition)->count();//数据总数

        $page = new\Think\Page($count,2);
        $nowPage = isset($_GET['p']) ? intval($_GET['p']) : 1;
        $page->setConfig('first','第一页');
        $page->setConfig('prev','前一页');
        $page->setConfig('next','后一页');

        $user= $userModel->where($condition)->page($nowPage.',2')->select();
        $show = $page->show();
        $this->assign('page',$show);
        $this->assign('user',$user);

        $this->display();
    }

//退出管理员登录

	public function logout(){	
		session('[destroy]');
		$this->display();
		redirect(U('Admin/admins/login'),2,' ');
	}
	

}

?>