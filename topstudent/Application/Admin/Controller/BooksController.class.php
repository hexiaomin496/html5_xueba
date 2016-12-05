<?php
   namespace Admin\Controller;
   use Think\Controller;
   class BooksController extends Controller{
     //各个课本浏览函数
   	 public function index(){
   	 
   	   $booksModel=M("books");
       //导入分页
       import('Org.Util.Page');
       $count=$booksModel->count();
       //每一页显示的记录数为3
       $page=new \Think\Page($count,3);
       $nowPage=isset($_GET['p'])?intval($_GET['p']):1;
       $page->setConfig('first','第一页');
       $page->setConfig('prev','前一页');
       $page->setConfig('next','后一页');
       //实现分页查看信息
       $books=$booksModel->order('book_publish desc')->page($nowPage.',3')->select();
       $show=$page->show();
       $this->assign('page',$show);
       $this->assign('books',$books);
       $this->display();
    }

     //添加课本封面后的添加课本信息函数
   	 public function create(){
        $booksModel=D("books");
        $id=$_GET['book_id'];
        $books=$booksModel->find($id);
        $this->assign('books',$books);
        $this->display();


    }

    //增加或者编辑后的保存课本信息函数
    public function save(){

        if(IS_POST){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize=3145728 ;// 设置附件上传大小
        $upload->exts=array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  = THINK_PATH; // 设置附件上传根目录
        $upload->savePath  ='../Public/uploads/'; // 设置附件上传（子）目录
        // 上传文件 
        $info   =   $upload->upload();
        // dump($info);
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功
             //$this->success('上传成功！');
            //创建模型
            $bookModel = M('books');
            //组织数据
            $data=$bookModel->create();
           
            //设置thumb字段属性(目录+名字)
           $data['book_img']=$info['fileField']['savepath'].$info['fileField']['savename'];
             
            // $bookModel->add($data);
           
                     
          // $model=M("Books");
          // $model->create();
          // dump($data);
          if($bookModel->save($data)){
            $this->success("添加成功",U("Books/index"));
          }
          else{
            $this->error("添加失败",U("Books/create"));
          }
         }
       }
     }
      
     //课本封面上传函数    
   	 public function  doAdd(){
   	 	$upload= new \Think\Upload();//实例化上传类
   	 	$upload->maxsize=3145728;
   	 	$upload->exts= array('jpg','gif','png','jpeg');
   	 	$upload->rootPath = THINK_PATH;
   	 	$upload->savePath='../Public/uploads/';
      // $upload->savetime= date();

   	 	//上传文件
   	 	$info = $upload->upload();
   	 	if(!$info){
   	 		$this->error($upload->getError());
   	 	}else{
   	 		$booksModel=M('books');
   	 		$data=$booksModel->create();
            
            //设置thumb字段属性
            $data['book_cover']=$info['thumb']['savepath'].$info['thumb']['savename'];
            // $data['book_publish']=$info['thumb']['savetime'];
            $z = $booksModel->add($data);
            if($z){
                $this->success('数据添加成功', U('create',array('book_id'=>$z)));
            }else{
                $this->showError('数据添加失败');
            }
            
   	 	}
   	 }

     // public function  upload(){
     //  $upload= new \Think\Upload();//实例化上传类
     //  $upload->maxsize=3145728;
     //  $upload->exts= array('jpg','gif','png','jpeg');
     //  $upload->rootPath = THINK_PATH;
     //  $upload->savePath='../Public/upload/';
     //  // $upload->savetime= date();

     //  //上传文件
     //  $info = $upload->upload();
     //  if(!$info){
     //    $this->error($upload->getError());
     //  }else{
     //    $booksModel=M('books');
     //    $data=$booksModel->create();
            
     //        //设置thumb字段属性
     //    $data['book_img']=$info['thumb']['savepath'].$info['thumb']['savename'];
     //        // $data['book_publish']=$info['thumb']['savetime'];
     //    $booksModel->add($data);
     //    echo ($booksModel);
     //  }
     // }

       public function edit(){
         $booksModel=D("books");
         $id=$_GET['id'];
         $books=$booksModel->find($id);
         $this->assign('books',$books);
         if(IS_POST){
          $model=M("Books");
          $model->create();
          if($model->save()){
            $this->success("修改成功",U("Books/index"));
          }
          else{
            $this->error("修改失败",U("Books/add"));
          }
         }

         
         $this->display();
       }
      
      //课本单项删除函数
       public function delete(){
         $id=I('id');
         $booksModel=M('books');
         if($booksModel->where("book_id=$id")->delete()){
            $this->success('删除成功');
         }else{
            $this->showError('删除失败');
         }
       }
   }
?>