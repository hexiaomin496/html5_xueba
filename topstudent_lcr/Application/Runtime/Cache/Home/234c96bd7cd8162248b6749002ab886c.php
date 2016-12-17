<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>学霸养成</title>
<link href="/all/topstudent/Public/home/css/public.css" rel="stylesheet" type="text/css" />
<link href="/all/topstudent/Public/home/css/person.css" rel="stylesheet" type="text/css" />

</head>
<body>
<div class="header">
    <div class="mybody">
        <a href="#"><img src="/all/topstudent/Public/home/images/logo.jpg" alt="logo" /></a>
        <div class="login">
        <!--<?php
 ?>-->
        	<?php
 if(!isset($_SESSION['user_username'])||$_SESSION['user_username']==''){ echo "<a href='#'>登录</a> | <a href='#'>注册</a>"; } else{ echo "欢迎你&nbsp;".$_SESSION['user_username']."&nbsp;&nbsp;<a href='/all/topstudent/index.php/Home/users/logout'>退出</a>"; } ?>
        
           
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
        <img src="/all/topstudent/Public/home/images/ad.jpg" width="1200" height="100" alt="ad" />
    </div>
</div>

<div class="content">
    <div class="mybody">
        <div class="bread"><span>您现在的位置：</span><a href="<?php echo U('Home/personal/index');?>">首页</a> > <a href="<?php echo U('Home/personal/index');?>">个人中心</a></div>
        <!--个人中心left-->
        <div class="personal_left">
            <div class="user">
                <a href="#"><img src="/all/topstudent/Public/<?php echo ($user['head_picture']); ?>" width="157" height="157" alt="user" /></a>
                <p><?php echo ($user['user_username']); ?></p>
            </div>
            <ul class="left_nav">
                    <li class="left_nav_now"><a href="<?php echo U('Home/index/index');?>">首页</a></li>
                    <li><a href="<?php echo U('Home/personal/myquestions');?>">我的问题</a></li>
                    <li><a href="<?php echo U('Home/personal/myanswers');?>">我的回答</a></li>
                    <li><a href="<?php echo U('Home/video/index');?>">视频收藏</a></li>
                    <li><a href="<?php echo U('Home/tests/index');?>">试卷收藏</a></li>
                    <li><a href="<?php echo U('Home/personal/myself');?>">个人管理</a></li>
                    
                    <li><a href="<?php echo U('Home/personal/certeacher');?>">教师认证</a></li>
            </ul>       
        </div>
        <!--个人中心right-->
        <div class="personal_form_right">
            <h1>我的积分<span> My points</span></h1>
            <div class="exper">
                <div class="userhead"><img src="/all/topstudent/Public/<?php echo ($user['head_picture']); ?>" width="100" height="100" alt="" /></div>
                <div class="schedule">
                    <div class="am-progress am-progress-striped">
                    <?php
 $score = $user['score']; echo $score; $a = $score/100; $a = floor($a); $b = $score%100; ?>
                        <div class="am-progress-bar am-progress-bar-secondary" style="width: <?php echo ($b); ?>%"></div>
                    </div>
                </div>
                <div class="number">
                    <div class="h2"><?php echo ($b); ?>/100</div>
                    <div class="h3">LV<?php echo ($a); ?></div>
                </div>
            </div>
            <div class="exper1 form_bg">
                <h1>个人信息</h1>
                <ul>
                    <li>姓名<span><?php echo ($user['user_username']); ?></span></li>
                    <li>电话<span><?php echo ($user['user_phone']); ?></span></li>
                    <li>学习阶段<span><?php echo ($user['user_stage']); ?></span></li>
                    <li>是否教师<span><?php echo ($user['user_judge']); ?></span></li>
                </ul>
            </div>
            <div class="exper1 exper2 form_bg">
                <h1>个人介绍</h1>
                <ul>
                    <li class="garyli"><?php echo ($user['user_introduce']); ?></li>
                </ul>
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