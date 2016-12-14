<?php
namespace Home\Controller;
use Think\Controller;

class PersonalController extends Controller{	
	//查看是否登录


	public function index(){
		if (!isset($_SESSION['user_username']) || $_SESSION['user_username']=='') {
    		$this->error('请先登录','Users/login');
    	}
    	
		$user = M('usertab');
		$userid = $_SESSION['userid'];
		
		$where = 'user_id='.$userid;
		$result = $user->where($where)->find();
		$this->assign('user',$result);
		$this->display();
	}

	public function myself(){
		$user = M('usertab');
		$userid = $_SESSION['userid'];
		$where = 'user_id='.$userid;
		$result = $user->where($where)->find();
		$this->assign('user',$result);
		
		$this->display();
	}

	public function edit(){	
		if (IS_POST) {
			
			$model = M("usertab");
			$b = $model->create();
			if($model->save()){	
				$this->success("修改成功",'index');
			}
			else{	
				$this->error("修改失败或未作修改");
			}
		}
		else{	
			$this->error('等待');
		}
	}

	public function editImg(){	
		if (IS_POST) {
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize=3145728 ;// 设置附件上传大小
        $upload->exts=array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  = THINK_PATH; // 设置附件上传根目录
        $upload->savePath  ='../Public/Head/'; // 设置附件上传（子）目录 
        $info   =   $upload->upload();
;
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功
             //$this->success('上传成功！');
            //创建模型
            $user = M('usertab');
            //组织数据
            $id = $_SESSION['userid'];
            $findid = 'user_id='.$id;;
            $b = $user->where($findid)->find();
            
            //设置thumb字段属性(目录+名字)
           $data['user_img']=$info['headimg']['savepath'].$info['headimg']['savename'];
           $b['user_img']=$data['user_img'];
          
           $result = $user->save($b);

			if($result){

				$this->success("添加成功",'myself');
			}
			else{	
				$this->error("添加失败");
			}
		}
	}
	}

	

}

?>