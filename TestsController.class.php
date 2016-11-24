<?php
   namespace Admin\Controller;
   use Think\Controller;
   class TestsController extends Controller{
   	 public function index(){
   	 	$testsModel=M('tests');
   	 	$tests=$testsModel->select();
   	 	$this->assign('tests',$tests);
   	 	$this->display();
   	 }

   	 public function create(){
   	 	$this->display();
   	 }

   	 public function  store(){
   	 	$upload= new \Think\Upload();//实例化上传类
   	 	$upload->maxsize=3145728;
   	 	$upload->exts= array('jpg','gif','png','jpeg');
   	 	$upload->rootPath = THINK_PATH;
   	 	$upload->savePath='../Public/uploads/';

   	 	//上传文件
   	 	$info = $upload->upload();
   	 	if(!$info){
   	 		$this->error($upload->getError());
   	 	}else{
   	 		$testsModel=M('tests');
   	 		$data=$booksModel->create();

            //设置thumb字段属性
            $data['thumb']=$info['thumb']['savepath'].$info['thumb']['savename'];

            //添加
            if($testsModel->add($data)){
               $this->success('数据添加成功','index');

            }else{
               $this->showError('数据添加失败');
            }
   	 	}
   	 }

       public function edit(){
         $id=I('id');

         $testsModel=M('tests');
         $data=$testsModel->find($id);

         $this->assign('tests',$data);
         $this->display();
       }

       public function update(){
         $testsModel=M('tests');
         $data=$testsModel->create();

         if ($testsModel->save($data)) {
            $this->success('课本更新成功','index');
         }else{
            this->error('课本更新失败')；
         }
       }

       public function delete(){
         $id=I('id');
         $testsModel=M('tests');
         if($testsModel->where("id=$id")->delete()){
            $this->success('删除成功');
         }else{
            $this->showError('删除失败');
         }
       }
   }
?>