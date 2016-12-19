<?php
namespace Home\Controller;
use Think\Controller;
class PersonalController extends Controller {
    public function index(){
        //查看是否登录
        if (!isset($_SESSION['user_username']) || $_SESSION['user_username']=='') {
            $this->error('请先登录',U('Home/users/login'));
        }
        
        $user = M('usertab');
        $userid = $_SESSION['id'];
        
        //var_dump($userid);
        $result = $user->where($userid)->find();
        $this->assign('user',$result);
        $this->display();
    }
    public function myquestions(){
    	$id = $_SESSION['id'];
        //var_dump($id);
        if(!isset($id)){
            $this->error("请登录！",U('Home/users/login'));
        }
        else{
    	$queModel = M('question');
        $userTabModel = M('usertab');

        $dataa = $userTabModel -> where($id)->find();

        
        //分页
        $count = $queModel->where($id)->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count,4);
        $Page->setConfig('header','<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('last','末页');
        $Page->setConfig('first','首页');
        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');

        $show = $Page->show();// 分页显示输出


    	$data = $queModel->where($id)->order('publish desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('page',$show);// 赋值分页输出

    	$this->assign('list',$data);
        $this->assign('lists',$dataa);
    	$this->display();
         }
    }
    public function quedetails($qid){
    	//问题部分$qid:data.que_id
    	$queModel = M('question');
        $ansModel = M('answer');
        //用户id
    	$id = $_SESSION['id'];
    	$ids = $id["user_id"];
        session('que_que',$qid);
        //var_dump($qid);
    	//var_dump($ids);
    	//$condition['question.user_id'] = $ids;
    	$condition['que_id'] = $qid;

        $cond['ans_que_id'] = $qid;
        //$cond['que_id'] = $qid;
        //var_dump($cond);
        $where['user_id'] = $ids;
    	//var_dump($qid);
    	//var_dump($ids);
        //更新question表中的字段que_view
        $wh['que_id'] = $qid;
        $find_number = $queModel->field('que_view')->where($wh)->find();
        $find_number['que_view'] += 1;
        $save['que_view'] = $find_number['que_view'];
       
        
        //$queModel->where($wh)->save($save);

    	$data = $queModel->where($condition)->find();

        //导入分页
        //$count = $ansModel->where($cond)->count();// 查询满足要求的总记录数
        $count1 = $queModel->field('ans_count')->where($condition)->find();
        $count = $count1['ans_count'];
        //var_dump($count);
     
        $Page = new \Think\Page($count,3);// 实例化分页类 传入总记录数和每页显示的记录数(25)

        $Page->setConfig('header','<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('last','末页');
        $Page->setConfig('first','首页');
        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');

        $show = $Page->show();// 分页显示输出

        //回答
        $data1 = $queModel->Field('answer.content as ans_content,answer.publish as ans_publish,answer.ans_username,question.user_id,usertab.score as user_score,answer.ans_que_id')->join('RIGHT JOIN answer ON question.que_id = answer.ans_que_id' )->join('usertab ON answer.user_id = usertab.user_id' )->where($cond)->order('ans_publish desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        //var_dump($data1);
        

        //我的提问和我的回答部分
        $userModel = M('usertab');
        $data2 = $userModel->where($where)->find();

        //热门问题部分
        $hotQue = $queModel->order('que_view desc')->limit(5)->select();

    	$this->assign('list',$data);
        $this->assign('lists',$data1);
        $this->assign('listss',$data2);
        $this->assign('llist',$hotQue);
        $this->assign('page',$show);// 赋值分页输出

    	$this->display();
    }
    public function addanswers(){
        $id = $_SESSION['id'];
        $que = $_SESSION['que_que'];//得到回答的问题que_id
        //var_dump($que);

        $ansModel = M('answer');
        $userModel = M('usertab');
        $queModel = M('question');
        //如果回答问题成功，为此用户添加分数,并未此用户的回答数+1
        $user_scoree = $userModel->field('score,reply_count')->where($id)->find();
        $userdata['score'] = $user_scoree['score']+10;
        $userdata['reply_count'] = $user_scoree['reply_count'] + 1;

        //如果回答成功，为此问题的回答数+1
        $que_ans_count = $queModel->field('ans_count')->where("que_id=$que")->find();
        $quedata['ans_count'] = $que_ans_count['ans_count']+1;

        $name = $userModel->Field('user_username')->where($id)->find();
        //var_dump($name);
        //$idcount=$ansModel->getLastInsId();
        //$data=$newsModel->add();
        //$data['ans_id'] = $idcount+1;
        $data['content'] = I('post.content');
        //var_dump(I('post.content'));
        $data['user_id'] = $id['user_id'];
        //var_dump($id['user_id']);
        $data['ans_que_id'] = $que;
        $data['action'] = '回答问题';
        $data['score'] = 10;
        $data['ans_username'] = $name['user_username'];
        $data['ans_view'] = 0;
        $time = time();
        $pub_time = date("Y-m-d H:i:s", $time);
        $data['publish'] = $pub_time;
        //var_dump($pub_time);
        $result = $ansModel->add($data);
        if($result){
            $iddd = $result;
            //var_dump($iddd);
            $userModel->where($id)->save($userdata);
            $queModel->where("que_id=$que")->save($quedata);
            $this->success('发表成功',"quedetails/qid/{$que}");
        }else{
            $this->error('发表失败');
        }   

    }
    public function hotquedetails($qid){
        //问题部分
        $queModel = M('question');
        //用户id
        $id = $_SESSION['id'];
        $ids = $id["user_id"];
        //var_dump($ids);
        //$condition['question.user_id'] = $ids;
        $condition['que_id'] = $qid;
        $where['user_id'] = $ids;
        //var_dump($qid);
        //var_dump($ids);

        $data = $queModel->where($condition)->find();
        //导入分页
        //$count = $queModel->join('RIGHT JOIN answer ON question.que_id = answer.ans_que_id' )->where($condition)->count();// 查询满足要求的总记录数
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

        //回答
        //$data1 = $queModel->Field('answer.content as ans_content,answer.publish as ans_publish,answer.ans_username')->join('RIGHT JOIN answer ON question.que_id = answer.ans_que_id' )->where($condition)->order('ans_publish desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        $data1 = $queModel->Field('answer.content as ans_content,answer.publish as ans_publish,answer.ans_username,usertab.score as user_score')->join('RIGHT JOIN answer ON question.que_id = answer.ans_que_id' )->join('usertab ON answer.user_id = usertab.user_id' )->where($condition)->order('ans_publish desc')->limit($Page->firstRow.','.$Page->listRows)->select();

        //我的提问和我的回答部分
        $userModel = M('usertab');
        $data2 = $userModel->where($where)->find();

        //热门问题部分
        $hotQue = $queModel->order('que_view desc')->limit(5)->select();

        $this->assign('list',$data);
        $this->assign('lists',$data1);
        $this->assign('listss',$data2);
        $this->assign('llist',$hotQue);
        $this->assign('page',$show);// 赋值分页输出

        $this->display();
    }
    public function myanswers(){
        $ansModel = M('answer');
        $userModel = M('usertab');
        $id = $_SESSION['id'];
        $condition['answer.user_id'] = $id['user_id'];
        $con['user_id'] = $id['user_id'];

        $dataa = $userModel->where($id)->find();
        

        //导入分页
        //$count = $ansModel->join('RIGHT JOIN question ON question.que_id = answer.ans_que_id' )->where($condition)->count();// 查询满足要求的总记录数
        $count1 = $userModel->field('reply_count')->where($con)->find();
        $count = $count1['reply_count'];
     
        $Page = new \Think\Page($count,4);// 实例化分页类 传入总记录数和每页显示的记录数(25)

        $Page->setConfig('header','<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('last','末页');
        $Page->setConfig('first','首页');
        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');

        $show = $Page->show();// 分页显示输出

        $data = $ansModel->Field('answer.content as ans_content,question.content as que_content,answer.ans_id,answer.publish as ans_publish,question.pag,answer.ans_view,question.que_view,question.ans_count,answer.user_id')->join('RIGHT JOIN question ON question.que_id = answer.ans_que_id' )->where($condition)->order('ans_publish desc')->limit($Page->firstRow.','.$Page->listRows)->select();

        $this->assign('list',$data);
        $this->assign('page',$show);// 赋值分页输出
        $this->assign('lists',$dataa);

        $this->display();
    }
     public function ansdetails($aid){
        $ansModel = M('answer');
        $queModel = M('question');


        $id = $_SESSION['id'];
        $condition['answer.user_id'] = $id['user_id'];
        $condition['ans_id'] = $aid;
        session('ans_aid',$aid);
        //var_dump($aid);

        //更新question表中的que_view字段
        $wh['ans_id'] = $aid;
        //var_dump($wh);
        $find_number = $queModel->field('que_view')->join('answer ON question.que_id = answer.ans_que_id' )->where($wh)->find();
        
        $find_number['que_view'] += 1;
        $save['que_view'] = $find_number['que_view'];
        $queModel->where($wh)->save($save);

        $que = $ansModel->field('answer.ans_que_id')->where($condition)->find();
        $where['que_id'] = $que['ans_que_id'];
        //var_dump($que);
        session("ss_que",$que);
        //var_dump($_SESSION['ss_que']);

        $data = $queModel->where($where)->find();
        //导入分页
        //$count = $queModel->join('RIGHT JOIN answer ON question.que_id = answer.ans_que_id' )->where($where)->count();// 查询满足要求的总记录数
        $count1 = $queModel->field('ans_count')->where($where)->find();
        $count = $count1['ans_count'];
     
        $Page = new \Think\Page($count,4);// 实例化分页类 传入总记录数和每页显示的记录数(25)

        $Page->setConfig('header','<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('last','末页');
        $Page->setConfig('first','首页');
        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');

        $show = $Page->show();// 分页显示输出

        $data1 = $queModel->Field('answer.content as ans_content,question.content as que_content,answer.ans_id,answer.publish as ans_publish,question.pag,answer.ans_view,question.ans_count,answer.user_id,answer.ans_username,usertab.score as user_score')->join('answer ON question.que_id = answer.ans_que_id')->join('usertab ON answer.user_id = usertab.user_id' )->where($where)->order('ans_publish desc')->limit($Page->firstRow.','.$Page->listRows)->select();
 

        $ids = $id["user_id"];
        $where['user_id'] = $ids;
        $userModel = M('usertab');
        $data2 = $userModel->where($where)->find();

        //热门问题部分
        $hotQue = $queModel->order('que_view desc')->limit(5)->select();
        
        $this->assign('list',$data);
        $this->assign('lists',$data1);
        $this->assign('listss',$data2);
        $this->assign('llist',$hotQue);
        $this->assign('page',$show);// 赋值分页输出

        $this->display();
    }
    public function doansAdd(){
        $id = $_SESSION['id'];
        $que = $_SESSION['ss_que'];//得到回答的问题que_id
        $ans_aid = $_SESSION['ans_aid'];
        $whe['que_id'] = $que['ans_que_id'];
        //var_dump($ans_aid);
        //var_dump($que);

        $ansModel = M('answer');
        $userModel = M('usertab');
        $queModel = M('question');
        //如果回答问题成功，为此用户添加分数,并未此用户的回答数加1
        $user_scoree = $userModel->field('score,reply_count')->where($id)->find();
        $userdata['score'] = $user_scoree['score']+10;
        $userdata['reply_count'] = $user_scoree['reply_count']+1;
        //如果回答成功，为此问题的回答数+1
        $que_ans_count = $queModel->field('ans_count')->where($whe)->find();
        $quedata['ans_count'] = $que_ans_count['ans_count']+1;

        $name = $userModel->Field('user_username')->where($id)->find();
        //var_dump($name);
        
        //$data=$ansModel->add();
        //$idcount=$ansModel->getLastInsID();
        
        //$data['ans_id'] = $idcount+1;
        $data['content'] = I('post.content');
        $data['user_id'] = $id['user_id'];
        $data['ans_que_id'] = $que['ans_que_id'];
        $data['action'] = '回答问题';
        $data['score'] = 10;
        $data['ans_username'] = $name['user_username'];
        $data['ans_view'] = 0;
        $time = time();
        $pub_time = date("Y-m-d H:i:s", $time);
        $data['publish'] = $pub_time;
        //var_dump($pub_time);
        $result = $ansModel->add($data);
        if($result){
            $iddd = $result;
            //var_dump($iddd);
            $userModel->where($id)->save($userdata);
             $queModel->where($whe)->save($quedata);
            $this->success('评论成功',"ansdetails/aid/{$ans_aid}");
        }else{
            $this->error('评论失败');
        }       
       
    }
    public function certeacher()
    {
        $this->display();
    }
    //xiaodi
    public function upload()
    {
        //设置文件格式
        $upload = new \Think\Upload();
        $upLoad->maxSize = 3145728;
        $upload->exts = array('jpg','gif','png','jpeg');
        $upload->rootPath = './public/';//设置附件上传根目录
        $upload->savePath = 'Teacher/';//设置附件上传
        //上传照片
        $picture = $upload->upload();

        if($picture===false){
            $this->error('照片上传失败');
        }else{
            //获得表单数据
            $data = array(
                // 'user_name' => $_SESSION['user_username'],
                'user_name' => '唠唠唠',
                'tea_school' => $_POST['school'],
                'tea_subject' => $_POST['subject'],
                'tea_credit' => '认证中',
                'tea_score' => $_SESSION['user_score'], 
                'tea_image' => $picture['fileField']['savepath'].$picture['fileField']['savename']
            );
            $teacherModel = M('teachertab');
            $teacher = $teacherModel->add($data);
            $this->success('申请成功,认证中...');
        }
    }
    public function myself(){
        $user = M('usertab');
        $userid = $_SESSION['id'];
        $where = 'user_id='.$userid;
        $result = $user->where($userid)->find();
        $this->assign('user',$result);
        
        $this->display();
    }
    public function edit(){ 
        if (IS_POST) {
            
            $model = M("usertab");
            $b = $model->create();
            if($model->save()){ 
                $this->success("修改成功",'index');
            }
            else{   
                $this->error("修改失败或未作修改");
            }
        }
        else{   
            $this->error('等待');
        }
    }
    public function editImg(){  
        if (IS_POST) {
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize=3145728 ;// 设置附件上传大小
            $upload->exts=array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath  = THINK_PATH; // 设置附件上传根目录
            $upload->savePath  ='../Public/Head/'; // 设置附件上传（子）目录 
            $info   =   $upload->upload();
;
            if(!$info) {// 上传错误提示错误信息
                $this->error($upload->getError());
            }else{// 上传成功
                 //$this->success('上传成功！');
                //创建模型
                $user = M('usertab');
                //组织数据
                $id = $_SESSION['id'];
                $findid = 'user_id='.$id;;
                $b = $user->where($id)->find();
                
                //设置thumb字段属性(目录+名字)
               $data['head_picture']=$info['headimg']['savepath'].$info['headimg']['savename'];
               $b['head_picture']=$data['head_picture'];
              
               $result = $user->save($b);

                    if($result){

                        $this->success("添加成功",'myself');
                    }
                    else{   
                        $this->error("添加失败");
                    }
            }
        }
    }

    
}