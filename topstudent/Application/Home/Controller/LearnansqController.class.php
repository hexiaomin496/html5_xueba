<?php
namespace Home\Controller;
use Think\Controller;
class LearnansqController extends Controller {
    public function __construct(){  
        parent::__construct();
        if(isset($_SESSION['user_username'])){  
            $user = M('usertab');
            $userid = $_SESSION['id'];
            $where = 'user_id='.$userid;
            $result = $user->where($where)->find();
            $this->assign('user',$result);
        }
        else{   
            session('id',-1);
        }

    }
    public function index(){
        
        $id = $_SESSION['id'];
       
        $queModel = M('question');
        $userModel = M('usertab');
        //用户信息和热门问题
        $id = "user_id=".$id;
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
        $condition = 'que_id='.$qid;
        $condition1 = 'ans_que_id='.$qid;
        //var_dump($id);
        //更新question表中的字段que_view
        $wh = 'que_id='.$qid;
        $find_number = $queModel->field('que_view')->where($wh)->find();
        $find_number['que_view'] += 1;
        $save['que_view'] = $find_number['que_view'];
       
        
        $result = $queModel->where($wh)->save($save);
        //热门问题部分
        $hotdata = $queModel->where()->limit(0,6)->select();
        $id = "user_id=".$id;
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

        $ansModel = M('answer');
        $userModel = M('usertab');
        $queModel = M('question');
        //如果此用户的用户状态为正常则让他回答，否则提示错误
        $status = $userModel->where("user_id = $id")->find();
        
        if($status['user_status'] =='正常'){
            //如果回答问题成功，为此用户添加分数，并为此用户的回答数+1
            $user_scoree = $userModel->field('score,reply_count')->where($id)->find();
            $userdata['score'] = $user_scoree['score']+10;
            $userdata['reply_count'] = $user_scoree['reply_count']+1;
            //如果回答成功，为此问题的回答数+1
            $que_ans_count = $queModel->field('ans_count')->where("que_id=$que")->find();

            $quedata['ans_count'] = $que_ans_count['ans_count']+1;

            $where = "user_id=".$id;
            $name = $userModel->Field('user_username')->where($where)->find();

            
            //添加内容判断
            $data['content'] = I('post.content');
            if($data['content'] == ''){
                $this->error('请添加回答内容！');
            }
            else{
                //var_dump(I('post.content'));
                $data['user_id'] = $id;
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
        }
        else{
            $this->error('对不起！您已被封禁，不能发表回答！');
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
        $id = "user_id=".$id;
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
         //查看是否登录
        if (!isset($_SESSION['user_username']) || $_SESSION['user_username']=='') {
            $this->error('请先登录',U("users/login"));
        }
        $content = I('post.content');
        $title = I('post.title');
        $pag = I('post.pag');
        $id = $_SESSION['id'];
        $userModel = M('usertab');
        //如果此用户的用户状态为正常则让他回答，否则提示错误
        $status = $userModel->where("user_id = $id")->find();
        
        if($status['user_status'] =='正常'){
            $ids = "user_id=".$id;
            if($content&&$title&&$pag){
                $queModel = M('question');
                $userModel = M('usertab');
                //如果发布问题成功，在usertab表上为提问数+1,并且为score+5
                $user_ask = $userModel->field('ask_count,score')->where($ids)->find();
                $userdata['ask_count'] = $user_ask['ask_count'] + 1; 
                $userdata['score'] = $user_ask['score'] + 5;
               
                $username = $userModel->field('user_username')->where($ids)->find();
                //var_dump($username);
                $id = $_SESSION['id'];
                $data['user_id'] = $id;
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
                $data['status'] = '已上传';
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
        else{
            $this->error('对不起！您已被封禁，不能发表回答！');
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
}
