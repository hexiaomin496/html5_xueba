<?php
   namespace Admin\Controller;
   use Think\Controller;
   class TestsController extends Controller{
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
   }
?>