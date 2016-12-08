<?php
namespace Admin\Controller;
use Think\Controller;
class QuestionsController extends Controller {

   public function __construct() {
    parent::__construct();
    
    if (!isLogin()) {
      $this->error("请先登录", U("Admins/login"));
    }
  }
    public function index(){
      $Model = M('question'); // 实例化questions对象
     
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
      $list = $Model->order('que_id')->limit($Page->firstRow.','.$Page->listRows)->select();
    
      $this->assign('list',$list);// 赋值数据集
      
      $this->assign('page',$show);// 赋值分页输出

      $this->display();
    }
	/*public function select(){
		$this->display();
	}*/
	public function edit($id){
        //获取id
        //$id = I('que_id');
        //获取数据
        $stuModel = M('question');

        $data = $stuModel->where("que_id=$id")->find();
        //分配数据
        $this->assign('list',$data);

        $this->display();
    }
   public function del($id){
        //$id = I('que_id');
        $Model = M('question');
        $teaModel = M('answer');

        //如果此问题有回复时，先删除回复再删除问题
        $teadata = $teaModel->where("ans_que_id=$id")->delete();

        if($Model->where("que_id=$id")->delete()){
             $this->success('删除成功',U('index'));
        }else{
             $this->showError('删除失败');
        }
    }
    public function query(){
        $Model = M('question');

        $starttime1 = I('post.date1');
        $endtime1 = I('post.date2');

        $starttime2 = strtotime($starttime1);
        $endtime2 = strtotime($endtime1);

        $starttime = date("Y-m-d H:i:s", $starttime2);
        $endtime = date("Y-m-d H:i:s", $endtime2);

        $condition['publish'] = array('between',array($starttime,$endtime));

        $count = $Model->where($condition)->count();// 查询满足要求的总记录数
        //var_dump($count);
        $Page = new \Think\Page($count,4);// 实例化分页类 
        $Page->setConfig('header','<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('last','末页');
        $Page->setConfig('first','首页');
        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');

        $data = $Model->where($condition)->order('que_id')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('list',$data);

        $show = $Page->show();// 分页显示输出
        $this->assign('page',$show);// 赋值分页输出
  
        $this->display();
    }
    public function search(){ 
        $Model = M('question');
        $value = I('post.search_value');

        $condition['content'] = array('like','%'.$value.'%');

        $count = $Model->where($condition)->count();
        //var_dump($count);
        $Page = new \Think\Page($count,3);        
        $Page->setConfig('header','<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('last','末页');
        $Page->setConfig('first','首页');
        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
 
        $data = $Model->where($condition)->limit($Page->firstRow.','.$Page->listRows)->select();
        //var_dump($data);
        $this->assign('list',$data);
        $show = $Page->show();// 分页显示输出
        //var_dump($show);
        $this->assign('page',$show);// 赋值分页输出

        $this->display();
    }
    public function destory(){
        $model = M("question"); //获取当期模块的操作对象 
        $ans_model = M("answer");

        $id = $_POST['id'];  //判断id是数组还是一个数值 
        
         //判断id是数组还是一个数值
         if(is_array($id)){
          $ans_where = 'ans_que_id in('.implode(',',$id).')';
          $where = 'que_id in('.implode(',',$id).')';
         }else{
           $ans_where = 'ans_que_id in('.implode(',',$id).')';
            $where = 'que_id='.$id;
         }

         $ans_list=$ans_model->where($ans_where)->delete();
         $list=$model->where($where)->delete();

         if($list!==false) {
          $this->success("成功删除{$list}条！");
         }else{
          $this->error('删除失败！');
         }
    }
}