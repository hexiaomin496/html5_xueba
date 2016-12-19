<?php
namespace Admin\Controller;
use Think\Controller;
class VideosController extends Controller{
	public function __construct() {
		parent::__construct();

		if (!isLogin()) {
			$this->error("请先登录", U("Admins/login"));
		}
	}

	public function index(){
		$videosModel=M('videos');
		$videos=$videosModel->select();

		$this->assign('videos',$videos);
		$count = $videosModel->count();// 查询满足要求的总记录数
		 $Page = new \Think\Page($count,4);// 实例化分页类 传入总记录数和每页显示的记录数(25)

      $Page->setConfig('header','<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
      $Page->setConfig('prev','上一页');
      $Page->setConfig('next','下一页');
      $Page->setConfig('last','末页');
      $Page->setConfig('first','首页');
      $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');

      $show = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
      $list = $videosModel->order('video_id')->limit($Page->firstRow.','.$Page->listRows)->select();

      $this->assign('list',$list);// 赋值数据集

      $this->assign('page',$show);// 赋值分页输出
		$this->display();
	}

	public function create(){
		$id=I('video_id');
		$video = M('videos')->find($id);
		$this->assign('newVideos',$video);
		$this->display();

	}
	public function save(){
		if (IS_POST) {
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize=3145728 ;// 设置附件上传大小
        $upload->exts=array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  = THINK_PATH; // 设置附件上传根目录
        $upload->savePath  ='../Public/Images/'; // 设置附件上传（子）目录

        // 上传文件
        $info   =   $upload->upload();
        // dump($info);
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功
             //$this->success('上传成功！');
            //创建模型
            $videoModel = M('videos');
            //组织数据
            $data=$videoModel->create();

            //设置thumb字段属性(目录+名字)
           $data['video_img']=$info['video_img']['savepath'].$info['video_img']['savename'];

           $b = $videoModel->save($data);

			if($b){

				$this->success("添加成功",'index');
			}
			else{
				$this->error("添加失败");
			}
		}
	}

}




	public function store(){
		$videos=M('videos');
		$linfo=$videos->select();
		//1.展现表单 2.接收表单数据
		if(!empty($_POST)){
			//判断是否为视频
			$type=$_FILES['video_name']['type'];
			switch($type){
				case 'video/mp4': $ok=1;break;
				case 'video/ogg': $ok=1;break;
				case 'audio/ogg': $ok=1;break;
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
						$_POST['video']=$video_name;//视频路径名存入数据库
						$_POST['video_title']=$video_Formerly;//视频原名存入数据库

					}
				}
				//thinkphp框架有方法实现数据收集 数据模型对象->creat()

				$a=$videos->create();
				$z=$videos->add();
				if($z){

					$newVideos=M('videos');
					$video = $newVideos->find($z);
					$this->assign('newVideos',$video);

					//$this->display();
					$this->success("更新成功",U('create',array('video_id'=>$z)));
				}else{
					echo "error";
				}

			}else{
				$this->error('您上传的不是视频文件或者视频格式不符合',U('videos/index'));
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
       //批量删除
       public function deleteAll(){
       		$booksModel = M('books');
       		$id = $_GET['id'];
       		$i=0;
       		foreach ($id as $key => $value) {
       			$it=$value;
       			//$it=(int)$it;
       			$where = 'book_id='.$it;
       			$list[$i]=$booksModel->where($where)->delete();
       			$i++;
       		}


       		if($list){
       			$this->success("成功删除{$i}条",U('index'));
       		}
       		else{
       			$this->error('删除失败');
       		}
       }

       //时间查询
       public function query(){
        $videosModel = M('videos');

        //$starttime = strtotime(I('post.date1'));
        //$endtime = strtotime(I('post.date2'));
        $starttime1 = I('post.date1');
        $endtime1 = I('post.date2');

        $starttime2 = strtotime($starttime1);
        $endtime2 = strtotime($endtime1);

        $starttime = date("Y-m-d H:i:s", $starttime2);
        $endtime = date("Y-m-d H:i:s", $endtime2);

        $condition['video_publish'] = array('between',array($starttime,$endtime));
        $data = $videosModel->where($condition)->count();
         $data = $videosModel->where($condition)->select();
        $this->assign('videos2',$data);

       $count = $videosModel->where($condition)->count();// 查询满足要求的总记录数
        //var_dump($count);
        $Page = new \Think\Page($count,4);// 实例化分页类
        $Page->setConfig('header','<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('last','末页');
        $Page->setConfig('first','首页');
        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');

        $data = $videosModel->where($condition)->order('video_id')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('list',$data);

        $show = $Page->show();// 分页显示输出
        $this->assign('page',$show);// 赋值分页输出
        $this->display();

    }
}
?>