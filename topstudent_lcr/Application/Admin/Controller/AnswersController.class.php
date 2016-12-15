<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Model\studentquestiontabModel;
class AnswersController extends Controller {

	

    public function index(){
        $que = M('question');
        
        $count = $que ->Field('answer.content as ans_content,question.content as que_content,answer.publish as ans_publish,question.publish as que_publish')->join('RIGHT JOIN answer ON question.que_id = answer.ans_que_id' )->count();
        
        $Page = new \Think\Page($count,4);// 实例化分页类 
        $Page->setConfig('header','<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;每页<b></b>条&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('last','末页');
        $Page->setConfig('first','首页');
        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');

        $show = $Page->show();// 分页显示输出
        $list = $que->Field('answer.content as ans_content,question.content as que_content,answer.publish as ans_publish,question.publish as que_publish,answer.ans_username,question.que_id,answer.ans_que_id,answer.ans_id')->join('RIGHT JOIN answer ON question.que_id = answer.ans_que_id' )->limit($Page->firstRow.','.$Page->listRows)->select();

        $this->assign('list',$list);
        $this->assign('page',$show);// 赋值分页输出

        $this->display();
    }
    /*public function select(){
		$this->display();
	}*/
	public function edit($ids,$idq){
        //获取数据
        $newsModel = M('answer');
        //$data=$newsModel->select();
        $condition['ans_id'] = $ids;
        $condition['ans_que_id'] = $idq;
        var_dump($ids);

        $list = $newsModel->Field('answer.content as ans_content,question.content as que_content,answer.publish as ans_publish,question.publish as que_publish,answer.ans_username,question.que_id,answer.ans_que_id,answer.ans_id,question.title,question.pag')->join('question ON answer.ans_que_id = question.que_id' )->where($condition)->find();
        
        //分配数据
        $this->assign('list',$list);

        $this->display();
    }
   public function del($ids,$idq){
        //$id = I('que_id');
        $newsModel = M('answer');
        $condition['ans_id'] = $ids;
        $condition['ans_que_id'] = $idq;

        if($newsModel->where($condition)->delete()){
             $this->success('删除成功',U('index'));
        }else{
             $this->showError('删除失败');
        }
    }
    public function destory(){
        $model = M("answer"); //获取当期模块的操作对象 
        $id = $_POST['id'];  //判断id是数组还是一个数值 

         //判断id是数组还是一个数值
         if(is_array($id)){
          $where = 'ans_id+ans_que_id in('.implode(',',$id).')';
         }else{
          $where = 'ans_id+ans_que_id='.$id;
         }
         //dump($where);
         $list=$model->where($where)->delete();
         if($list!==false) {
          $this->success("成功删除{$list}条！");
         }else{
          $this->error('删除失败！');
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

        $condition['question.publish'] = array('between',array($starttime,$endtime));

        $count = $Model->join('RIGHT JOIN answer ON question.que_id = answer.ans_que_id' )->where($condition)->count();
        $Page = new \Think\Page($count,3);

        $data = $Model->Field('answer.content as ans_content,question.content as que_content,answer.publish as ans_publish,question.publish as que_publish,answer.ans_username,question.que_id,answer.ans_que_id,answer.ans_id,question.title,question.pag')->join('RIGHT JOIN answer ON question.que_id = answer.ans_que_id' )->where($condition)->limit($Page->firstRow.','.$Page->listRows)->select();

        $Page->setConfig('header','<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('last','末页');
        $Page->setConfig('first','首页');
        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');

        $show = $Page->show();// 分页显示输出

        $this->assign('studentquestiontab',$data);
        $this->assign('page',$show);

        $this->display();
    }
    public function search(){ 
        $Model = M('question');
        //$ans_content = M('answer');
        $value = I('post.search_value');

        $condition['question.content'] = array('like','%'.$value.'%');
        $condition['answer.content'] = array('like','%'.$value.'%');
        $condition['_logic'] = 'or';

        /*$count1 = $Model->join('RIGHT JOIN answers ON questions.que_id = answers.que_id' )->where($condition)->count();
        $count2 = $ans_content->join('questions ON answers.que_id = questions.que_id' )->where($where)->count();
        $count = $count1 + $count2;*/
        $count = $Model->join('RIGHT JOIN answer ON question.que_id = answer.ans_que_id' )->where($condition)->count();

        $Page       = new \Think\Page($count,5);

        $data1 = $Model->Field('answer.content as ans_content,question.content as que_content,answer.publish as ans_publish,question.publish as que_publish,answer.ans_username,question.que_id,answer.ans_que_id,answer.ans_id,question.title,question.pag')->join('RIGHT JOIN answer ON question.que_id = answer.ans_que_id' )->where($condition)->select();
        //$data2 = $ans_content->join('questions ON answers.que_id = questions.que_id' )->where($where)->select();

        $Page->setConfig('header','<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('last','末页');
        $Page->setConfig('first','首页');
        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');

        $show = $Page->show();// 分页显示输出

        //$data = array_merge($data1,$data2);

        $this->assign('list_que',$data1);

        $this->assign('page',$show);

        $this->display();
    }
}