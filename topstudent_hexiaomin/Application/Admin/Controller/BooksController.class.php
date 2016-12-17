<?php
   namespace Admin\Controller;
   use Think\Controller;
   class BooksController extends Controller{

   	public function __construct() {
    parent::__construct();
    
    if (!isLogin()) {
      $this->error("请先登录", U("Admins/login"));
    }
  }

     //各个课本浏览函数
   	 public function index(){
   	 
   	   $booksModel=M("books");
       //导入分页
       /*import('Org.Util.Page');
       $count=$booksModel->count();
       //每一页显示的记录数为3
       $page=new \Think\Page($count,3);
       $nowPage=isset($_GET['p'])?intval($_GET['p']):1;
       $page->setConfig('first','第一页');
       $page->setConfig('prev','前一页');
       $page->setConfig('next','后一页');
       //实现分页查看信息
       */
       $books=$booksModel->order('book_publish desc')->page($nowPage.',3')->select();
       //$show=$page->show();
       //$this->assign('page',$show);
       $this->assign('books',$books);
       $count = $booksModel->count();// 查询满足要求的总记录数
		 $Page = new \Think\Page($count,4);// 实例化分页类 传入总记录数和每页显示的记录数(25)

      $Page->setConfig('header','<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
      $Page->setConfig('prev','上一页');
      $Page->setConfig('next','下一页');
      $Page->setConfig('last','末页');
      $Page->setConfig('first','首页');
      $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');

      $show = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
      $list = $booksModel->order('book_id')->limit($Page->firstRow.','.$Page->listRows)->select();
    
      $this->assign('list',$list);// 赋值数据集
      
      $this->assign('page',$show);// 赋值分页输出
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
       
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }
        else{// 上传成功
             //$this->success('上传成功！');
          //$path = '/uploads/';
            foreach($info as $file){
              $path = substr($file['savepath'], 9);
              $string = $path.$file['savename'];
              $i.=$string.',';

          }
          $a = substr($i, 0, -1) ;
          // print_r($a);
          // exit();

            //创建模型
            $bookModel = M('books');
            //组织数据
            $data=$bookModel->create();
           
            //设置thumb字段属性(目录+名字)
           $data['book_img']=$a;
             
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

        //日期查询
       public function query(){
        $booksModel = M('books');

        //$starttime = strtotime(I('post.date1'));
        //$endtime = strtotime(I('post.date2'));
        $starttime1 = I('post.date1');
        $endtime1 = I('post.date2');

        $starttime2 = strtotime($starttime1);
        $endtime2 = strtotime($endtime1);

        $starttime = date("Y-m-d H:i:s", $starttime2);
        $endtime = date("Y-m-d H:i:s", $endtime2);

        $condition['book_publish'] = array('between',array($starttime,$endtime));
        $data = $booksModel->where($condition)->count();
         $data = $booksModel->where($condition)->select();
        $this->assign('books2',$data);

        $count = $booksModel->where($condition)->count();// 查询满足要求的总记录数
        //var_dump($count);
        $Page = new \Think\Page($count,4);// 实例化分页类 
        $Page->setConfig('header','<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('last','末页');
        $Page->setConfig('first','首页');
        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');

        $data = $booksModel->where($condition)->order('book_id')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('list',$data);

        $show = $Page->show();// 分页显示输出
        $this->assign('page',$show);// 赋值分页输出
        $this->display();
   }
   }
?>