<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>学霸养成</title>
<link href="/topstudent/Public/home/css/public.css" rel="stylesheet" type="text/css" />
<link href="/topstudent/Public/home/css/person.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="/topstudent/Public/home/css/photo.css" />
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
            <li class="navnow"><a href="<?php echo U('Home/tests/index');?>">学霸试卷</a></li>
            <li><a href="<?php echo U('Home/personal/index');?>">个人中心</a></li>
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
    	<div class="bread"><span>您现在的位置：</span><a href="首页.html">首页</a> > <a href="学霸试卷.html">学霸试卷</a> > <a href="#">小学一年级语文上册黄冈密卷</a></div>

<div class="kePublic">
<!--效果html开始-->
<div class="MainBg">
  <div class="HS10"></div>
  <div class="Title">
    <h1>人教版小学一年级语文上册</h1>
    <span class="Counter">（<span class="CounterCurrent">1</span>/10）</span> </div>
  <div class="SpaceLine"></div>
  <div class="OriginalPicBorder">
    <div id="OriginalPic">
      <div id="aPrev" class="CursorL"></div>
      <div id="aNext" class="CursorR"></div>
      
      <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><p class="Hidden">
	      <span class="Summary FlLeft"></span>
	      <span class="SliderPicBorder FlRight">
	      	<img src="images/paper1.jpg" />
	      </span> 
	      <span class="Clearer"></span> 
	      <span class="More"> 
	      	<a href="images/paper1.jpg" target="_blank"> 查看原图</a> 
	      <span class="OptLine"></span> 
      	</p><?php endforeach; endif; else: echo "" ;endif; ?>

    </div>
  </div>
  <div class="SpaceLine"></div>
  <div class="HS15"></div>
  <div class="ThumbPicBorder"> <img src="/topstudent/Public/home/images/ArrowL.jpg" id="btnPrev" class="FlLeft" style="cursor:pointer;" />
    <div class="jCarouselLite FlLeft">
      <ul id="ThumbPic">
	      <?php if(is_array($lists)): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><li rel='1'><img src="/topstudent/Public/home/images/paper1.jpg" width="160" height="240" /></li><?php endforeach; endif; else: echo "" ;endif; ?>
      </ul>
      <div class="Clearer"></div>
    </div>
    <img src="/topstudent/Public/home/images/ArrowR.jpg" id="btnNext" class="FlLeft" style="cursor:pointer;" />
    <div class="Clearer"></div>
  </div>
  <div class="HS15"></div>
</div>

</div>
</div>
</div>

<div class="footer">
	<div class="mybody">
    <p>版权所有：河北师范大学软件学院 永信指导小组 地址：石家庄市南二环东路20号 冀ICP备字201401号</p>
    </div>
</div>

<script type="text/javascript" src="/topstudent/Public/home/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="/topstudent/Public/home/js/jquery.jcarousellite.min.js"></script>
<script type="text/javascript">
//缩略图滚动事件

$(".jCarouselLite").jCarouselLite({
	btnNext: "#btnNext",
	btnPrev: "#btnPrev",
	scroll: 1,
	speed: 240,
	circular: false,
	visible: 8
});
</script> 
<script type="text/javascript">
var currentImage;
var currentIndex = -1;

//显示大图(参数index从0开始计数)
function showImage(index){

	//更新当前图片页码
	$(".CounterCurrent").html(index + 1);

	//隐藏或显示向左向右鼠标手势
	var len = $('#OriginalPic img').length;
	if(index == len - 1){
		$("#aNext").hide();
	}else{
		$("#aNext").show();
	}

	if(index == 0){
		$("#aPrev").hide();
	}else{
		$("#aPrev").show();
	}

	//显示大图            
	if(index < $('#OriginalPic img').length){
		var indexImage = $('#OriginalPic p')[index];

		//隐藏当前的图
		if(currentImage){
			if(currentImage != indexImage){
				$(currentImage).css('z-index', 2);	
				$(currentImage).fadeOut(0,function(){
					$(this).css({'display':'none','z-index':1})
				});
			}
		}

		//显示用户选择的图
		$(indexImage).show().css({'opacity': 0.4});
		$(indexImage).animate({opacity:1},{duration:200});

		//更新变量
		currentImage = indexImage;
		currentIndex = index;

		//移除并添加高亮
		$('#ThumbPic img').removeClass('active');
		$($('#ThumbPic img')[index]).addClass('active');

		//设置向左向右鼠标手势区域的高度                        
		//var tempHeight = $($('#OriginalPic img')[index]).height();
		//$('#aPrev').height(tempHeight);
		//$('#aNext').height(tempHeight);                        
	}
}

//下一张
function ShowNext(){
	var len = $('#OriginalPic img').length;
	var next = currentIndex < (len - 1) ? currentIndex + 1 : 0;
	showImage(next);
}

//上一张
function ShowPrep(){
	var len = $('#OriginalPic img').length;
	var next = currentIndex == 0 ? (len - 1) : currentIndex - 1;
	showImage(next);
}

//下一张事件
$("#aNext").click(function(){
	ShowNext();
	if($(".active").position().left >= 144 * 5){
		$("#btnNext").click();
	}
});

//上一张事件
$("#aPrev").click(function(){
	ShowPrep();
	if($(".active").position().left <= 144 * 5){
		$("#btnPrev").click();
	}
});

//初始化事件
$(".OriginalPicBorder").ready(function(){
	ShowNext();

	//绑定缩略图点击事件
	$('#ThumbPic li').bind('click',function(e){
		var count = $(this).attr('rel');
		showImage(parseInt(count) - 1);
	});
});
</script>
</body>
</html>