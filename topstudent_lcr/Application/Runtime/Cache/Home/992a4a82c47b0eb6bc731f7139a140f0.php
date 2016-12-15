<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>学霸养成</title>
<link href="/all/topstudent/Public/home/css/public.css" rel="stylesheet" type="text/css" />
<link href="/all/topstudent/Public/home/css/login.css" rel="stylesheet" type="text/css" />
<script src="/all/topstudent/Public/home/js/jquery.min.js" type="text/javascript"></script>
</head>

<body>
<div class="header">
	<div class="mybody">
    	<a href="#"><img src="/all/topstudent/Public/home/images/logo.jpg" alt="logo" /></a>
        <div class="login">
        	<a href="<?php echo U(login);?>">登录</a> | <a href="<?php echo U(register);?>">注册</a>
        </div>
        <ul class="nav">
        	<li><a href="首页.html">首页</a></li>
            <li><a href="学霸问答.html">学霸问答</a></li>
            <li><a href="课本点读.html">课本点读</a></li>
            <li><a href="视频讲解.html">视频讲解</a></li>
            <li><a href="学霸试卷.html">学霸试卷</a></li>
            <li class="navnow"><a href="个人中心.html">个人中心</a></li>
        </ul>
    </div>
</div>
<div class="ad">
	<div class="mybody">
    	<img src="/all/topstudent/Public/home/images/ad.jpg" width="1200" height="100" alt="ad" />
    </div>
</div>

<div class="content1">
    	<div class="contentright">
        	<h1>用户注册</h1>
            <form action="/all/topstudent/index.php/Home/users/doReg" method="post">
                <input type="text" name="username" class="username" placeholder="请输入您的用户名">
                <input type="password" id="password" name="password" class="password" placeholder="请输入您的密码">
                <input type="password" id="repwd" name="password" class="password" placeholder="请确认您的密码">
                <button type="submit" id="submit" class="submit_button" disabled="disabled">&nbsp;&nbsp;注&nbsp;&nbsp;册</button>

            </form>
      </div>
</div>

<div class="footer">
	<div class="mybody">
    <p>版权所有：河北师范大学软件学院 永信指导小组 地址：石家庄市南二环东路20号 冀ICP备字201401号</p>
    </div>
</div>
</body>
</html>
<script type="text/javascript">
			$("#repwd").blur(function(){	
				$("#password").val() == $("#repwd").val() ? $("#submit").removeAttr("disabled"): alert("用户密码与重复密码不相符");
			})
</script>