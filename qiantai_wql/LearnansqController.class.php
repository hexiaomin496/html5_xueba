<?php
namespace Home\Controller;
use Think\Controller;
class LearnansqController extends Controller {
    public function index(){
    	$id = $_SESSION['id'];
    	$queModel = M('question');
        $userModel = M('usertab');
        //用户信息和热门问题
        $data1 = $userModel->where($id)->find();
        //热门问题部分
        $data2 = $queModel->where()->order('que_view desc')->limit(0,6)->select();
    	 //分页
        $count = $queModel->where()->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count,3);
        $Page->setConfig('header','<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('last','末页');
        $Page->setConfig('first','首页');
        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');

        $show = $Page->show();// 分页显示输出

    	$data = $queModel->where()->order('que_id desc')->limit($Page->firstRow.','.$Page->listRows)->select();

    	$this->assign('list',$data);
        $this->assign('listss',$data1);
        $this->assign('llist',$data2);
    	$this->assign('page',$show);// 赋值分页输出
        $this->display();
    }
    public function lquedetails($qid){
    	$id = $_SESSION['id'];
    	$queModel = M('question');
    	$userModel = M('usertab');

    	session('ss_que',$qid);
    	//var_dump($_SESSION['ss_que']);
    	$condition['que_id'] = $qid;
    	$condition1['ans_que_id'] = $qid;
    	//var_dump($id);
        //更新question表中的字段que_view
        $wh['que_id'] = $qid;
        $find_number = $queModel->field('que_view')->where($wh)->find();
        $find_number['que_view'] += 1;
        $save['que_view'] = $find_number['que_view'];
       
        
        $queModel->where($wh)->save($save);

        //热门问题部分
    	$hotdata = $queModel->where()->limit(0,6)->select();
    	$data1 = $userModel->where($id)->find();
    	//问题部分显示
    	$data = $queModel->where($condition)->find();
    	//回答部分显示
    	//导入分页
        //$count = $queModel->join('RIGHT JOIN answer ON question.que_id = answer.ans_que_id')->where($condition)->count();// 查询满足要求的总记录数
        $count1 = $queModel->field('ans_count')->where($condition)->find();
        $count = $count1['ans_count'];

        $Page = new \Think\Page($count,3);// 实例化分页类 传入总记录数和每页显示的记录数(25)

        $Page->setConfig('header','<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('last','末页');
        $Page->setConfig('first','首页');
        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');

        $show = $Page->show();// 分页显示输出

    	$data2 = $queModel->field('answer.ans_username,usertab.score as user_score,answer.content as ans_content,answer.publish as ans_publish,answer.ans_view,answer.ans_id')->join('answer ON question.que_id = answer.ans_que_id' )->join('usertab ON answer.user_id = usertab.user_id' )->where($condition1)->order('ans_publish desc')->limit($Page->firstRow.','.$Page->listRows)->select();


    	$this->assign('listss',$data1);
    	$this->assign('list',$data);
    	$this->assign('lists',$data2);
        $this->assign('llist',$hotdata);
    	$this->assign('page',$show);// 赋值分页输出
    	$this->display();
    }
    public function addanswers(){
    	$id = $_SESSION['id'];
        $que = $_SESSION['ss_que'];//得到回答的问题que_id
        //var_dump($que);
        //var_dump($que);

        $ansModel = M('answer');
        $userModel = M('usertab');
        $queModel = M('question');
        //如果回答问题成功，为此用户添加分数，并为此用户的回答数+1
        $user_scoree = $userModel->field('score,reply_count')->where($id)->find();
        $userdata['score'] = $user_scoree['score']+10;
        $userdata['reply_count'] = $user_scoree['reply_count']+1;
        //如果回答成功，为此问题的回答数+1
        $que_ans_count = $queModel->field('ans_count')->where("que_id=$que")->find();
        $quedata['ans_count'] = $que_ans_count['ans_count']+1;


        $name = $userModel->Field('user_username')->where($id)->find();
        //var_dump($name);
        
        $data['content'] = I('post.content');
        //var_dump(I('post.content'));
        $data['user_id'] = $id['user_id'];
        $data['ans_que_id'] = $que;
        $data['action'] = '回答问题';
        $data['score'] = 10;
        $data['ans_username'] = $name['user_username'];
        $data['ans_view'] = 0;
        $time = time();
        $pub_time = date("Y-m-d H:i:s", $time);
        //var_dump($pub_time);
        $data['publish'] = $pub_time;
        //var_dump($data['publish']);
        //var_dump($pub_time);
        $result = $ansModel->add($data);
        if($result){
            $iddd = $result;
            //var_dump($iddd);
            $userModel->where($id)->save($userdata);
            $queModel->where("que_id=$que")->save($quedata);
            $this->success('发表成功',"lquedetails/qid/{$que}");
        }else{
            $this->error('发表失败');
        }   
    }
    public function hotlquedetails($qid){
        $id = $_SESSION['id'];
        $queModel = M('question');
        $userModel = M('usertab');

        session('ss_que',$qid);
        //var_dump($_SESSION['ss_que']);
        $condition['que_id'] = $qid;
        $condition1['ans_que_id'] = $qid;
        //var_dump($id);

        //热门问题部分
        $hotdata = $queModel->where()->limit(0,6)->select();
        $data1 = $userModel->where($id)->find();
        //问题部分显示
        $data = $queModel->where($condition)->find();
        //回答部分显示
        //导入分页
        //$count = $queModel->join('RIGHT JOIN answer ON question.que_id = answer.ans_que_id')->where($condition)->count();// 查询满足要求的总记录数
        $count1 = $queModel->field('ans_count')->where($condition)->find();
        $count = $count1['ans_count'];
     
        $Page = new \Think\Page($count,3);// 实例化分页类 传入总记录数和每页显示的记录数(25)

        $Page->setConfig('header','<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('last','末页');
        $Page->setConfig('first','首页');
        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');

        $show = $Page->show();// 分页显示输出

        $data2 = $queModel->field('answer.ans_username,usertab.score as user_score,answer.content as ans_content,answer.publish as ans_publish,answer.ans_view')->join('answer ON question.que_id = answer.ans_que_id' )->join('usertab ON answer.user_id = usertab.user_id' )->where($condition1)->order('ans_publish desc')->limit($Page->firstRow.','.$Page->listRows)->select();


        $this->assign('listss',$data1);
        $this->assign('list',$data);
        $this->assign('lists',$data2);
        $this->assign('llist',$hotdata);
        $this->assign('page',$show);// 赋值分页输出
        $this->display();
    }
    public function search(){
        $id = $_SESSION['id'];
        $queModel = M('question');
        $userModel = M('usertab');

        //查询符合关键词的问题
        $value = I('post.search');
        //var_dump($value);
        $condition['title'] = array('like','%'.$value.'%');
        $condition['content'] = array('like','%'.$value.'%');
        $condition['que_username'] = array('like','%'.$value.'%');
        $condition['_logic'] = 'or';

        //用户信息和热门问题
        $data1 = $userModel->where($id)->find();
        //热门问题部分
        $data2 = $queModel->where()->limit(0,6)->select();
         //分页
        $count = $queModel->where($condition)->count();// 查询满足要求的总记录数

        $Page = new \Think\Page($count,3);
        $Page->setConfig('header','<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('last','末页');
        $Page->setConfig('first','首页');
        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');

        $show = $Page->show();// 分页显示输出

        $data = $queModel->where($condition)->order('que_view desc')->limit($Page->firstRow.','.$Page->listRows)->select();

        $this->assign('list',$data);
        $this->assign('listss',$data1);
        $this->assign('llist',$data2);
        $this->assign('page',$show);// 赋值分页输出
        $this->display();
    }
    public function ask(){

        $this->display();  
    }
    public function asksubmit(){
        $content = I('post.content');
        $title = I('post.title');
        $pag = I('post.pag');
        $id = $_SESSION['id'];
        if($content&&$title&&$pag){
            $queModel = M('question');
            $userModel = M('usertab');
            //如果发布问题成功，在usertab表上为提问数+1,并且为score+5
            $user_ask = $userModel->field('ask_count,score')->where($id)->find();
            $userdata['ask_count'] = $user_ask['ask_count'] + 1; 
            $userdata['score'] = $user_ask['score'] + 5;
            $id = $_SESSION['id'];
            $username = $userModel->field('user_username')->where($id)->find();
            //var_dump($username);
            $data['user_id'] = $id['user_id'];
            $data['title'] = $title;
            $data['content'] = $content;
            $data['action'] = '提出问题';
            $data['score'] = 10;
            $time = time();
            $pub_time = date("Y-m-d H:i:s", $time);
            $data['publish'] = $pub_time;
            $data['que_img'] = NULL;
            $data['pag'] = $pag;
            $data['ans_count'] = 0;
            $data['que_view'] = 0;
            $data['que_username'] = $username['user_username'];
            $result = $queModel->add($data);
            if($result){
                $iddd = $result;
                //var_dump($iddd);
                $userModel->where($id)->save($userdata);
                $this->success('发表问题成功！',"index");
            }else{
                $this->error('发表问题失败');
            } 
        }
        else{
            $this->error('请正确输入问题格式！');
        }
        
    }
    public function primary(){
        $id = $_SESSION['id'];
        $queModel = M('question');
        $userModel = M('usertab');
        //用户信息和热门问题
        $data1 = $userModel->where($id)->find();
        //热门问题部分
        $data2 = $queModel->where()->limit(0,6)->select();
         //分页
        $pag['pag'] = '小学';
        $count = $queModel->where($pag)->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count,3);
        $Page->setConfig('header','<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('last','末页');
        $Page->setConfig('first','首页');
        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');

        $show = $Page->show();// 分页显示输出

        $data = $queModel->where($pag)->order('que_view desc')->limit($Page->firstRow.','.$Page->listRows)->select();

        $this->assign('list',$data);
        $this->assign('listss',$data1);
        $this->assign('llist',$data2);
        $this->assign('page',$show);// 赋值分页输出
        $this->display();
    }
    public function middle(){
        $id = $_SESSION['id'];
        $queModel = M('question');
        $userModel = M('usertab');
        //用户信息和热门问题
        $data1 = $userModel->where($id)->find();
        //热门问题部分
        $data2 = $queModel->where()->limit(0,6)->select();
         //分页
        $pag['pag'] = '初中';
        $count = $queModel->where($pag)->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count,3);
        $Page->setConfig('header','<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('last','末页');
        $Page->setConfig('first','首页');
        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');

        $show = $Page->show();// 分页显示输出

        $data = $queModel->where($pag)->order('que_view desc')->limit($Page->firstRow.','.$Page->listRows)->select();

        $this->assign('list',$data);
        $this->assign('listss',$data1);
        $this->assign('llist',$data2);
        $this->assign('page',$show);// 赋值分页输出
        $this->display();
    }
    public function math(){
        $id = $_SESSION['id'];
        $queModel = M('question');
        $userModel = M('usertab');
        //用户信息和热门问题
        $data1 = $userModel->where($id)->find();
        //热门问题部分
        $data2 = $queModel->where()->limit(0,6)->select();
         //分页
        $pag['pag'] = '数学';
        $count = $queModel->where($pag)->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count,3);
        $Page->setConfig('header','<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('last','末页');
        $Page->setConfig('first','首页');
        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');

        $show = $Page->show();// 分页显示输出

        $data = $queModel->where($pag)->order('que_view desc')->limit($Page->firstRow.','.$Page->listRows)->select();

        $this->assign('list',$data);
        $this->assign('listss',$data1);
        $this->assign('llist',$data2);
        $this->assign('page',$show);// 赋值分页输出
        $this->display();
    }
    public function chinese(){
        $id = $_SESSION['id'];
        $queModel = M('question');
        $userModel = M('usertab');
        //用户信息和热门问题
        $data1 = $userModel->where($id)->find();
        //热门问题部分
        $data2 = $queModel->where()->limit(0,6)->select();
         //分页
        $pag['pag'] = '语文';
        $count = $queModel->where($pag)->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count,3);
        $Page->setConfig('header','<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('last','末页');
        $Page->setConfig('first','首页');
        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');

        $show = $Page->show();// 分页显示输出

        $data = $queModel->where($pag)->order('que_view desc')->limit($Page->firstRow.','.$Page->listRows)->select();

        $this->assign('list',$data);
        $this->assign('listss',$data1);
        $this->assign('llist',$data2);
        $this->assign('page',$show);// 赋值分页输出
        $this->display();
    }
    public function english(){
        $id = $_SESSION['id'];
        $queModel = M('question');
        $userModel = M('usertab');
        //用户信息和热门问题
        $data1 = $userModel->where($id)->find();
        //热门问题部分
        $data2 = $queModel->where()->limit(0,6)->select();
         //分页
        $pag['pag'] = '英语';
        $count = $queModel->where($pag)->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count,3);
        $Page->setConfig('header','<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('last','末页');
        $Page->setConfig('first','首页');
        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');

        $show = $Page->show();// 分页显示输出

        $data = $queModel->where($pag)->order('que_view desc')->limit($Page->firstRow.','.$Page->listRows)->select();

        $this->assign('list',$data);
        $this->assign('listss',$data1);
        $this->assign('llist',$data2);
        $this->assign('page',$show);// 赋值分页输出
        $this->display();
    }
    
    /*public function zan(){
        $ans_id = I('POST.ans_id');

        var_dump($ans_id);
        $ansModel = M('answer');

        $num = $ansModel->where()->select();
        $da['ans_id'] = $ans_id;
        $data['ans_view'] = $num['ans_view']+1;
        $result = $ansModel->where($da)->save($data);
        if($result>0){
            $data['info'] = "ok";
            $data['status'] = 1;
            $this->ajaxReturn($data);
             
            exit();
        }
        else{
            $data['info'] = "fail";
            $data['status'] = 0;

            $this->ajaxReturn($data);
            exit();
        }
    }*/
    public function zan(){
        //$dataa['id']=I('post.id')?intval(trim(I('post.id')):0; 
        $id = I('post.id'); 
        if(!isset($_SESSION[$id+10000])){
            $cookiename = $id+10000;
            session($cookiename,$cookiename);

            $dataa=I('post.id');
            $ids = $_SESSION['id'];

            $obj = M("answer");
            $da['ans_id'] = $dataa;
            $data = $obj->where($da)->find();
            $where['ans_view'] = $data['ans_view']+1;
            $result = $obj->where($da)->save($where);

            $a = 1;
            dump($a);
        }
        else{
            exit();
        }
         
    }
    public function delzan(){
        $id = I('post.id'); 
        if(isset($_SESSION[$id+10000])){
            $cookiename = $id+10000;
            session_unset($cookiename);

            $dataa=I('post.id');
            $ids = $_SESSION['id'];

            $obj = M("answer");
            $da['ans_id'] = $dataa;
            $data = $obj->where($da)->find();
            $where['ans_view'] = $data['ans_view']-1;
            $result = $obj->where($da)->save($where);

            $a = 1;
            dump($a);     
        }
        else{
             $cookiename = $id+10000;
            session_unset($cookiename);

            $dataa=I('post.id');
            $ids = $_SESSION['id'];

            $obj = M("answer");
            $da['ans_id'] = $dataa;
            $data = $obj->where($da)->find();
            $where['ans_view'] = $data['ans_view']-1;
            $result = $obj->where($da)->save($where);

            $a = 1;
            dump($a);     
        }
    }
    /*public function zan($id){
        $userid = $_SESSION['id'];
        $sessionname = $id.$userid['user_id'].'10000';
        dump($_SESSION["$sessionname"]);
        $answerModel = M('answer');
        $con['ans_id'] = $id;
        $data = $answerModel->where($con)->find();
        $condition['ans_view'] = $data['ans_view'] + 1;
        $result = $answerModel->where($con)->find();
            
        if(!isset($_SESSION["$sessionname"])&&$result>0){
            session($sessionname,'10000');
            dump($_SESSION["$sessionname"]);
            $re = $answerModel->where($con)->save($condition);
            if($re>0){
                $queid = M('answer')->where($con)->find();
                $que_id = $queid['ans_que_id'];
                exit();
                $this->success('点赞成功',U("home/learnansq/lquedetails/qid/{$que_id}"));
            }
            else{
                $this->error('点赞失败');
            }
        }
        else{
            exit();
        }
        

        

    }*/

}
