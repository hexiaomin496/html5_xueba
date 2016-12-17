<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>学霸养成</title>
<link href="/topstudent/Public/home/css/public.css" rel="stylesheet" type="text/css" />
<link href="/topstudent/Public/home/css/person.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="header">
	<div class="mybody">
    	<a href="#"><img src="/topstudent/Public/home/images/logo.jpg" alt="logo" /></a>
        <div class="login">
        	<a href="#">登陆</a> | <a href="#">注册</a>
        </div>
         <ul class="nav">
            <li><a href="<?php echo U('Home/index/index');?>">首页</a></li>
            <li><a href="<?php echo U('Home/learnansq/index');?>">学霸问答</a></li>
            <li><a href="<?php echo U('Home/book/index');?>">课本点读</a></li>
            <li><a href="<?php echo U('Home/video/index');?>">视频讲解</a></li>
            <li><a href="<?php echo U('Home/tests/index');?>">学霸试卷</a></li>
            <li class="navnow"><a href="<?php echo U('Home/personal/index');?>">个人中心</a></li>
        </ul>
    </div>
</div>
<div class="ad">
	<div class="mybody">
    	<img src="/topstudent/Public/home/images/ad.jpg" width="1200" height="100" alt="ad" />
    </div>
</div>

<div class="content">
	<div class="mybody">
    	<div class="bread"><span>您现在的位置：</span><a href="<?php echo U('Home/personal/index');?>">首页</a> > <a href="<?php echo U('Home/personal/index');?>">个人中心</a></div>
		<!--个人中心left-->
        <div class="personal_left">
        	<div class="user">
            	<a href="#"><img src="/topstudent/Public/<?php echo ($lists["head_picture"]); ?>" width="157" height="157" alt="user" /></a>
                <p><?php echo ($lists["user_username"]); ?></p>
            </div>
            <ul class="left_nav">
                    <li><a href="<?php echo U('Home/personal/index');?>">首页</a></li>
                    <li><a href="<?php echo U('Home/personal/myquestions');?>">我的问题</a></li>
                    <li class="left_nav_now"><a href="<?php echo U('Home/personal/myanswers');?>">我的回答</a></li>
                    <li><a href="<?php echo U('Home/video/index');?>">视频收藏</a></li>
                    <li><a href="<?php echo U('Home/tests/index');?>">试卷收藏</a></li>
                    <li><a href="<?php echo U('Home/personal/myself');?>">个人管理</a></li>
                    
                    <li><a href="<?php echo U('Home/personal/certeacher');?>">教师认证</a></li>
            </ul>       
        </div>
        <!--个人中心right-->
        <div class="personal_form_right form_bg">
        <h1>我的问题<span> My question</span></h1>
        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><div class="question">
            	<h2><a href="<?php echo U('Home/personal/quedetails');?>/qid/<?php echo ($data["que_id"]); ?>" target="_blank"><?php echo ($data["content"]); ?></a></h2>
                <h4><?php echo ($data["publish"]); ?>&nbsp;&nbsp;&nbsp;&nbsp;回答：<?php echo ($data["ans_count"]); ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ($data["que_view"]); ?>人看过&nbsp;&nbsp;&nbsp;&nbsp;<span><?php echo ($data["pag"]); ?></span></h4>
            </div><?php endforeach; endif; else: echo "" ;endif; ?>
            
            <div class="page">
            	<?php echo ($page); ?>
    		</div>

        </div>
	</div>
</div>

<div class="footer">
	<div class="mybody">
    <p>版权所有：河北师范大学软件学院 永信指导小组 地址：石家庄市南二环东路20号 冀ICP备字201401号</p>
    </div>
</div>
</body>
</html>