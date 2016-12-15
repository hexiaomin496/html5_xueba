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
    public function testdetails(){
        
    	$this->display();
    }
}