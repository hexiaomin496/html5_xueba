<?php
   namespace Admin\Controller;
   use Think\Controller;
   class TestsController extends Controller{

     public function __construct() {
    parent::__construct();

    if (!isLogin()) {
      $this->error("请先登录", U("Admins/login"));
    }
  }
   	 public function index(){
   	    $testsModel=M("tests");
          //导入分页
         import('Org.Util.Page');
          $count=$testsModel->count();
          //每一页显示的记录数为3
          $page=new \Think\Page($count,3);
          $nowPage=isset($_GET['p'])?intval($_GET['p']):1;
          $page->setConfig('first','第一页');
          $page->setConfig('prev','前一页');
          $page->setConfig('next','后一页');

          $tests=$testsModel->order('test_publish desc')->page($nowPage.',3')->select();
          $show=$page->show();
          $this->assign('page',$show);
          $this->assign('tests',$tests);
        /*  $count = $testsModel->count();// 查询满足要求的总记录数
		 $Page = new \Think\Page($count,4);// 实例化分页类 传入总记录数和每页显示的记录数(25)

	      $Page->setConfig('header','<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
	      $Page->setConfig('prev','上一页');
	      $Page->setConfig('next','下一页');
	      $Page->setConfig('last','末页');
	      $Page->setConfig('first','首页');
	      $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');

	      $show = $Page->show();// 分页显示输出
	        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
	      $list = $testsModel->order('test_id')->limit($Page->firstRow.','.$Page->listRows)->select();

	      $this->assign('list',$list);// 赋值数据集

	      $this->assign('page',$show);// 赋值分页输出*/
          $this->display();
   	 }

   	 public function create(){
        $testsModel=D("tests");
        $id=$_GET['test_id'];
        $tests=$testsModel->find($id);
        $this->assign('tests',$tests);
        $this->display();


    }

      public function save(){

        if(IS_POST){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize=3145728 ;// 设置附件上传大小
        $upload->exts=array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  = THINK_PATH; // 设置附件上传根目录
        $upload->savePath  ='../Public/upload/'; // 设置附件上传（子）目录
        // 上传文件
        $info   =   $upload->upload();
        // dump($info);
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功
             //$this->success('上传成功！');
            //创建模型
            $testModel = M('tests');
            //组织数据
            $data=$testModel->create();

            //设置thumb字段属性(目录+名字)
           $data['test_img']=$info['fileField']['savepath'].$info['fileField']['savename'];


          if($testModel->save($data)){
            $this->success("添加成功",U("Tests/index"));
          }
          else{
            $this->error("添加失败",U("Tests/create"));
          }
         }
       }
     }

      public function  doAdd(){
      $upload= new \Think\Upload();//实例化上传类
      $upload->maxsize=3145728;
      $upload->exts= array('jpg','gif','png','jpeg');
      $upload->rootPath = THINK_PATH;
      $upload->savePath='../Public/upload/';
      // $upload->savetime= date();

      //上传文件
      $info = $upload->upload();

      if(!$info){
        $this->error($upload->getError());
      }else{
        $testsModel=M('tests');
        $data=$testsModel->create();

            //设置thumb字段属性
            $data['test_cover']=$info['thumb']['savepath'].$info['thumb']['savename'];
            // $data['test_publish']=$info['thumb']['savetime'];
            $z = $testsModel->add($data);
            dump($data);
            if($z){
                $this->success('数据添加成功', U('create',array('test_id'=>$z)));
            }else{
                $this->showError('数据添加失败');
            }

      }
     }


   	  public function edit(){
         $testsModel=D("tests");
         $id=$_GET['id'];
         $tests=$testsModel->find($id);
         $this->assign('tests',$tests);
         if(IS_POST){
          $model=M("tests");
          $model->create();
          if($model->save()){
            $this->success("修改成功",U("tests/index"));
          }
          else{
            $this->error("修改失败",U("tests/add"));
          }
         }


         $this->display();
       }


       public function delete(){
         $id=I('id');
         $testsModel=M('tests');

         if($testsModel->where("test_id=$id")->delete()){
            $this->success('删除成功');
         }else{
            $this->showError('删除失败');
         }
       }

        //批量删除
      	public function deleteAll(){
       		$testsModel = M('tests');
       		$id = $_GET['id'];
       		$i=0;
       		foreach ($id as $key => $value) {
       			$it=$value;
       			//$it=(int)$it;
       			$where = 'test_id='.$it;
       			$list[$i]=$testsModel->where($where)->delete();
       			$i++;
       		}


       		if($list){
       			$this->success("成功删除{$i}条",U('index'));
       		}
       		else{
       			$this->error('删除失败');
       		}
       }

        //日期查询
       public function query(){
        $testsModel = M('tests');

        //$starttime = strtotime(I('post.date1'));
        //$endtime = strtotime(I('post.date2'));
        $starttime1 = I('post.date1');
        $endtime1 = I('post.date2');

        $starttime2 = strtotime($starttime1);
        $endtime2 = strtotime($endtime1);

        $starttime = date("Y-m-d H:i:s", $starttime2);
        $endtime = date("Y-m-d H:i:s", $endtime2);

        $condition['test_publish'] = array('between',array($starttime,$endtime));
        $data = $testsModel->where($condition)->count();
         $data = $testsModel->where($condition)->select();
        $this->assign('tests2',$data);
        $this->display();
   }
   }
?>