<?php
namespace Admin\Controller;
use Think\Controller;
class VideosController extends Controller{
	public function index(){
		  $videosModel=M("videos");
          //导入分页
          import('Org.Util.Page');
          $count=$videosModel->count();
          //每一页显示的记录数为3
          $page=new \Think\Page($count,3);
          $nowPage=isset($_GET['p'])?intval($_GET['p']):1;
          $page->setConfig('first','第一页');
          $page->setConfig('prev','前一页');
          $page->setConfig('next','后一页');

          $videos=$videosModel->order('video_publish desc')->page($nowPage.',3')->select();
          $show=$page->show();
          $this->assign('page',$show);
          $this->assign('videos',$videos);
          $this->display();
	}

	public function create(){
		$this->display();
	}

	public function store(){
		$videos=D('videos');
		$linfo=$videos->table('')->select();

		//1.展现表单 2.接收表单数据
		if(!empty($_POST)){
			//判断是否为视频
			$type=$_FILES['video_name']['type'];
			switch($type){
				case 'video/mp4': $ok=1;break;
				case 'video/ogg': $ok=1;break;
				case 'video/webm': $ok=1;break;
			}
			if($ok){
				//判断附件是否有上传
				//如果有则实例化Upload,把附件上传到服务器指定位置
				//然后把附件的路径名或得到，存入$_POST
				if(!empty($_FILES)){
					$config = array(
						'rootPath' => './public/' ,//保存根路径
						'savePath' => 'Video/',//保存路径
					 );

					//附件被上传到路径：根目录/保存目录路径
					$upload= new \Think\Upload($config);
					//uploadOne会返回已经上传的附件信息
					$z=$upload->uploadOne($_FILES['video_name']);
					$v=$_FILES['video_name'];
					$video_Formerly=$v['name'];
					if(!$z){
						show_bug($upload->getError());
					}else{
						//拼装视频的路径名
						$video_name=$z['savepath'].$z['savename'];
						$_POST['video_name']=$video_name;
						$_POST['video_Formerly']=$video_Formerly;//视频原名存入数据库

					}
				}
				//thinkphp框架有方法实现数据收集 数据模型对象->creat()
				$a=$videos->create();
				$z=$videos->add();
				if($z){
					echo "success";
				}else{
					echo "error";
				}

			}else{
				$this->error('您上传的不是视频文件或者视频格式不符合',U('Uploadvideo/addVideo'));
			}
		}
	}

	 public function edit(){
         $id=I('id');

         $videosModel=M('videos');
         $data=$videosModel->find($id);

         $this->assign('videos',$data);
         $this->display();
       }

       public function update(){
         $videosModel=M('videos');
         $data=$videosModel->create();

         if ($videosModel->save($data)) {
            $this->success('视频更新成功','index');
         }else{
            $this->error('视频更新失败');
         }
       }

       public function delete(){
         $id=I('id');
         $videosModel=M('videos');
         if($videosModel->where("video_id=$id")->delete()){
            $this->success('删除成功');
         }else{
            $this->showError('删除失败');
         }
       }
}
?>