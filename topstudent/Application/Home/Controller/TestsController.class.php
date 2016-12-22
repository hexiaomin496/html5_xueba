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
        
        session('t_id',$id);
        //var_dump($_SESSION['t_id']);
        $id = "test_id=".$id;
       
        $data = $testsModel->where($id)->find();
        // dump($data);
        $this->assign('tests',$data);
    	$this->display();
    }
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
        //查看是否登录
        if (!isset($_SESSION['user_username']) || $_SESSION['user_username']=='') {
            $this->error('请先登录',U("users/login"));
        }
        $id = $_SESSION['id'];
        $condition['test_id'] = $ids;
        $condition['user_id'] = $id;
       
        $mytestsModel = M('my_tests');
        if($mytestsModel->where($condition)->select()){
            $this->error('不能重复收藏',U("home/tests/testdetails/id/{$ids}"));
        }
        $testsModel = M('tests');
        $wh['test_id'] = $ids;
        $tests = $testsModel->where($condition)->find();

        $data = array(
                'user_id' => $id,
                'test_id' => $ids,
                'test_title' => $tests['test_title'],
                'test_count' => $tests['test_count'],
                'test_img' => $tests['test_img'],
                'test_content' => $tests['test_content'],
                'test_type' => $tests['test_type'],
                'test_cover' => $tests['test_cover'],
                'test_publish' => $tests['test_publish']
            );

        if($mytestsModel->add($data)){
            $this->redirect('home/tests/testdetails/id/{$ids}');
        }else{
            $this->error('收藏失败');
        }
    }
}