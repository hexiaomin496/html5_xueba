<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>问答详情</title>
<link href="/topstudent/Public/home/css/questions.css" rel="stylesheet" type="text/css" />
<link href="/topstudent/Public/home/css/public.css" rel="stylesheet" type="text/css" />
<link href="/topstudent/Public/home/css/contentright.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="header">
	<div class="mybody">
    	<a href="#"><img src="/topstudent/Public/home/images/logo.jpg" alt="logo" /></a>
        <div class="login">
        	<a href="#">登陆</a> | <a href="#">注册</a>
        </div>
        <ul class="nav">
        	<li><a href="首页.html">首页</a></li>
            <li class="navnow"><a href="学霸问答.html">学霸问答</a></li>
            <li><a href="课本点读.html">课本点读</a></li>
            <li><a href="视频讲解.html">视频讲解</a></li>
            <li><a href="学霸试卷.html">学霸试卷</a></li>
            <li><a href="个人中心.html">个人中心</a></li>
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
	<div class="bread"><span>学霸养成</span> > <a href="#">学霸问答</a> > <a href="#">问答详情</a></div>
    <div class="right">
    	<div class="righttop">
        	<h1 class="title title2">我的问答<a href="#" class="ckgd"></a></h1>
            <div class="xzdr">
       	    	<img src="/topstudent/Public/home/images/dr1.jpg" width="150" height="190" alt="dr" class="xzdrimg"/>
                <div class="xzright">
                <div class="drname">
                <h1><?php echo ($listss["user_username"]); ?></h1>
                <span>
                <?php
 $str1 = $listss['score']; $str2 = $str1/100; echo LV.intval($str2); ?>
                </span>
                </div>
                <a href="#"><h3 class="tw">我的提问：<?php echo ($listss["ask_count"]); ?></h3></a>
                <a href="#"><h3 class="hd2">我的回答：<?php echo ($listss["reply_count"]); ?></h3></a>
                </div>
            </div>
      </div>
    	<div class="righttop righttop2">
        	<h1 class="title">热门问题<a href="#" class="ckgd">更多&nbsp;>></a></h1>
            <ul class="topul">
            <?php if(is_array($llist)): $i = 0; $__LIST__ = $llist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('Home/personal/hotquedetails');?>/qid/<?php echo ($data["que_id"]); ?>"><?php echo ($data["content"]); ?></a><span><?php echo ($data["publish"]); ?></span></li><?php endforeach; endif; else: echo "" ;endif; ?>
            
        </ul>
        </div>
    </div>
    <div class="left">
	  <div class="question">
      <div class="qtop">
        	<h1><span>问题：</span><?php echo ($list["title"]); ?></h1>
            <p><?php echo ($list["content"]); ?></p>
       </div>
            <div class="fl">
        	<div class="ssfl"><img src="/topstudent/Public/home/images/ssfl.gif" width="15" height="15" alt="ssfl" /><span>分类：<?php echo ($list["pag"]); ?></span></div>
            <div class="ssfl ssfl2"><img src="/topstudent/Public/home/images/sj.gif" width="15" height="15" alt="sj" /><span>时间：<?php echo ($list["publish"]); ?> </span></div>
            <div class="ssfl ssfl2"><img src="/topstudent/Public/home/images/twz.gif" width="15" height="15" alt="zz" /><span>提问者：<?php echo ($list["que_username"]); ?></span></div>
            <div class="ssfl ssfl2"><img src="/topstudent/Public/home/images/scan.gif" width="15" height="15" alt="zz" /><span><?php echo ($list["que_view"]); ?>人看过</span></div>
        </div>
        </div>
        <ul class="contentul">
        <li>
            <h3>我要回答：</h3>
                <form action="<?php echo U('Home/personal/doansAdd');?>" method="post">
                    <textarea placeholder="请输入回答内容" name="content" id="content" class="text"></textarea>
                    <input type="submit" value="提交" class="answerbtn" />
                </form>
        </li>
        <?php if(is_array($lists)): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><li>
            	<div class="lileft">
           	    <img src="/topstudent/Public/home/images/head.gif" width="80" height="80" alt="head" />
                </div>
                <div class="liright">
                	<div class="rtop">
                    	<h3>姓名：<?php echo ($data["ans_username"]); ?></h3>
                        <span class="level">
                        <?php
 $str1 = $data['user_score']; $str2 = $str1/100; echo LV.intval($str2); ?>
                        </span>
                        
                    </div>
                    <div class="rtop">
                    	<div class="hd">
                    	<h3>回答：</h3>
                        </div>
                        <div class="hdp">
                        <p><?php echo ($data["ans_content"]); ?></p>
                        </div>
                    </div>
                    <div class="ssfl ssfl2 ssflul"><img src="/topstudent/Public/home/images/sj.gif" width="15" height="15" alt="sj" /><span>时间：<?php echo ($data["ans_publish"]); ?></span></div>
                    
                </div>
            </li><?php endforeach; endif; else: echo "" ;endif; ?>   
        </ul>
        <div class="page">
            	<?php echo ($page); ?>
    </div>
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