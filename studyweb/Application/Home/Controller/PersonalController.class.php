<?php
namespace Home\Controller;
use Think\Controller;

class PersonalController extends Controller{	
	public function index(){	
		$user = M('usertab');
		$userid = $_SESSION['userid'];
		
		$where = 'user_id = '.$userid;
		//$result = $user->where($where)->find();

		// $this->assign('user',$result);
		$this->display();
	}

	public function certeacher()
	{
		$this->display();
	}

	public function upload()
	{
		//设置文件格式
		$upload = new \Think\Upload();
		$upLoad->maxSize = 3145728;
		$upload->exts = array('jpg','gif','png','jpeg');
		$upload->rootPath = './public/';//设置附件上传根目录
		$upload->savePath = 'Teacher/';//设置附件上传
		//上传照片
		$picture = $upload->upload();

		if($picture===false){
			$this->error('照片上传失败');
		}else{
			//获得表单数据
            $data = array(
        	    // 'user_name' => $_SESSION['user_username'],
        	    'user_name' => '唠唠唠',
        	    'tea_school' => $_POST['school'],
        	    'tea_subject' => $_POST['subject'],
        	    'tea_credit' => '认证中',
        	    'tea_score' => $_SESSION['user_score'], 
        	    'tea_image' => $picture['fileField']['savepath'].$picture['fileField']['savename']
        	);
		    $teacherModel = M('teachertab');
		    $teacher = $teacherModel->add($data);
		    $this->success('申请成功,认证中...');
		}
	}

	public function myvideos(){
		$collectVideoModel = M('collectvideo');
		$condition['user_id'] = '1';
		$collectVideoModel = $collectVideoModel->where($condition);
		//$collectvideo = $collectVideoModel->select();

		//分页
        $count = $collectVideoModel->count();
        $Page = new \Think\Page($count,4);
        $Page->setConfig('header','<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('last','末页');
        $Page->setConfig('first','首页');
        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %END% %HEADER%');

        $show = $Page->show();
        $data = $collectVideoModel->order('video_id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		
	    $this->assign('collect',$data);
	    $this->assign('page',$show);

		//$this->assign('collect',$collectvideo);
		// dump($collectvideo);
		// exit();
		$this->display();
	}
}

?>