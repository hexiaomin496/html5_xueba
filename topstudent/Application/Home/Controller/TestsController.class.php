<?php
namespace Home\Controller;
use Think\Controller;
class TestsController extends Controller {
    public function index(){
    	$testsModel = M('tests');

        //分页
        $count = $testsModel->count();
        $Page = new \Think\Page($count,4);
        $Page->setConfig('header','<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('last','末页');
        $Page->setConfig('first','首页');
        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %END% %HEADER%');

        $show = $Page->show();
        $data = $testsModel->order('test_publish desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        
        $this->assign('list',$data);
        $this->assign('page',$show);

        //热点推送--点击量
        $hotVideo = M('videos')->order('video_count desc')->limit(8)->select();
        $this->assign('hot',$hotVideo);

        $this->display();
    }
    public function testdetails($id){
        $testsModel = M('tests');
        $where['test_id'] = $id;
        session('t_id',$id);
        //var_dump($_SESSION['t_id']);
       
        $data = $testsModel->find($id);
        
        $this->assign('tests',$data);
    	$this->display();
    }
    /*public function collect(){
        $id = I('post.id');
        $u_id = $_SESSION['id'];
        //dump($id);
        //dump($u_id);
        $mytests = M('my_tests');
        $tests = M('tests');
        $data['test_id'] = $id;  

        $result = $mytests->where($data)->select();
        //dump($result);
        //如果此用户没有收藏过,则将此数据添加到my_tests表中
        if(!isset($_SESSION[$id+10000])&&$result>0){
            $sessionname = $id+10000;
            session($sessionname,$sessionname); 

            $test['test_id'] = $id;
            $where = $tests->where($test)->find();

            $condition['user_id'] = $u_id['user_id'];
            $condition['test_id'] = $id;
            $condition['test_title'] = $where['test_title'];
            $condition['test_content'] = $where['test_content'];
            $condition['test_type'] = $where['test_type'];
            $condition['test_cover'] = $where['test_cover'];
            $condition['test_img'] = $where['test_img'];
            $condition['test_publish'] = $where['test_publish'];
            $condition['test_count'] = $where['test_count'];
            $condition['collect'] = 0;
            //dump($condition);

            $mytests->add($condition);
        }*/
        /*if(!isset($_COOKIE[$_POST['id']+10000])&&$result>0){
            $cookiename = $_POST['id']+10000;
            setcookie($cookiename,40,time()+60,'/'); 
 
            $data['info'] = "ok";
            $data['status'] = '1';
            $this->ajaxReturn($data);
             
            exit();
        }
    }*/
    public function cancel(){
        $id = I('post.id');
        $u_id = $_SESSION['id'];
        
        $mytests = M('my_tests');
        $tests = M('tests');

        $data['test_id'] = $id; 
        $data['user_id'] = $u_id['user_id'];
        //删除session，以便能再次收藏
        $sessionname = $id+10000;
        unset ($_SESSION[$sessionname]);

        $mytests->where($data)->delete();
    }
    //试卷收藏
    public function collect($ids)
    {
        $id = $_SESSION['id'];
        $condition['test_id'] = $ids;
        $condition['user_id'] = $id['user_id'];
         //dump($condition);
       
        $mytestsModel = M('my_tests');
        if($mytestsModel->where($condition)->select()){
            $this->error('不能重复收藏',U("home/tests/testdetails/id/{$ids}"));
        }
        $testsModel = M('tests');
        $wh['test_id'] = $ids;
        $tests = $testsModel->where($wh)->find();

        $data = array(
                'user_id' => $id['user_id'],
                'test_id' => $ids,
                'test_title' => $tests['test_title'],
                'test_count' => $tests['test_count'],
                'test_img' => $tests['test_img'],
                'test_content' => $tests['test_content'],
                'test_type' => $tests['test_type'],
                'test_cover' => $tests['test_cover'],
                'test_publish' => $tests['test_publish']
            );
        
        //$collectvideo = $collectVideoModel->add($data);
        if($mytestsModel->add($data)){
            $this->success('收藏成功',U("home/tests/testdetails/id/{$ids}"));
        }else{
            $this->error('收藏失败');
        }
    }
}