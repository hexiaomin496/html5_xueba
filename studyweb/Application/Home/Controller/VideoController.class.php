<?php
namespace Home\Controller;
use Think\Controller;
class VideoController extends Controller{
    public function index()
    {  
        $videoModel = M('videos');

        //分页
        $count = $videoModel->count();
        $Page = new \Think\Page($count,4);
        $Page->setConfig('header','<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('last','末页');
        $Page->setConfig('first','首页');
        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %END% %HEADER%');

        $show = $Page->show();
        $data = $videoModel->order('video_publish desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		
	    $this->assign('list',$data);
	    $this->assign('page',$show);

        //热点推送--点击量
        $hotVideo = M('videos')->order('video_count desc')->limit(8)->select();
        $this->assign('hot',$hotVideo);

	$this->display();
    }

    //视频详情
    public function detail()
    {
        $condition['video_id'] = I('id');
        session('videoID',I('id'));
        $videoModel = M('videos');
        $video = $videoModel->where($condition)->select();
        $this->assign('video',$video);

        //点击量
        $count = M('videos')->where($condition)->setInc('video_count',1);

        //上一个
        $front = M('videos')->where('video_id<'.I('id'))->order('video_id desc')->limit('1')->find();
        if(!$front){
            $front['video_title'] = '';
        }
        $this->assign('front',$front);

        //下一个
        $next = M('videos')->where('video_id>'.I('id'))->order('video_id desc')->limit('1')->find();
        if(!$next){
            $next['title'] = '';
        }
        $this->assign('next',$next);

        //热点推送--点击量
        $hotVideo = M('videos')->order('video_count desc')->limit(8)->select();
        $this->assign('hot',$hotVideo);

        $this->display();
    } 

    //视频收藏
    public function collect()
    {
        $condition['video_id'] = I('id');
        // dump($condition);
        // exit();
        $collectVideoModel = M('collectvideo');
        if($collectVideoModel->where($condition)->select()){
            $this->error('不能重复收藏',U('home/personal/myvideos'));
        }
        $videoModel = M('videos');
        $video = $videoModel->where($condition)->select();

        $data = array(
                'user_id' => '1',
                'video_id' => I('id'),
                'video_title' => $video[0]['video_title'],
                'video_count' => $video[0]['video_count'],
                'video_img' => $video[0]['video_img']
            );
        //  dump($data);
        // exit();
        //$collectvideo = $collectVideoModel->add($data);
        if($collectVideoModel->add($data)){
            $this->success('收藏成功',U('home/personal/myvideos'));
        }else{
            $this->error('收藏失败');
        }
    }
}