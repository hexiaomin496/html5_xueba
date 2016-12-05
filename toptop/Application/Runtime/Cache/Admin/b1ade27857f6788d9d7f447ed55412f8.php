<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>学霸养成后台管理系统</title>
    <meta name="description" content="Source code generated using layoutit.com">
    <meta name="author" content="LayoutIt!">
    <link href="/topstudent/Public/admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="/topstudent/Public/admin/css/style.css" rel="stylesheet">
    <link href="/topstudent/Public/admin/css/styleww.css" rel="stylesheet">
</head>

<body>
<div class="container-fluid">
	<div class="row header">
    	<h1>学霸养成后台管理系统<span>欢迎您，王小明！<a href="login.html">退出</a></span></h1>
    </div>
</div>
<div class="container-fluid">
	<div class="row content">
    	<div class="col-md-2 col-xs-2 left">
        	<div class="panel-group" id="accordion">
    			<div class="panel panel-default">
        			<div class="panel-heading">
            			<h4 class="panel-title con">
                		<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">内容管理</a>
            			</h4>
        			</div>
        			<div id="collapseOne" class="panel-collapse collapse">
                        <div class="panel-body">
                        	<ul>
                            	<li><a href="内容管理-视频管理.html">视频管理</a></li>
                                <li><a href="内容管理-课本管理.html">课本管理</a></li>
                                <li><a href="内容管理-试卷管理.html">试卷管理</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title question">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">问答管理</a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse in">
                        <div class="panel-body">
                        	<ul>
                            	<li class="linow"><a href="#">问题审核</a></li>
                                <li><a href="<?php echo U('Admin/answers/index');?>">回复审核</a></li>
                            </ul>
                        </div>
        			</div>
    			</div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title user">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">用户管理</a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse">
                        <div class="panel-body">
                        	<ul>
                            	<li><a href="用户管理-用户列表.html">用户列表</a></li>
                                <li><a href="用户管理-教师管理.html">教师管理</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
		<div class="col-md-10 col-xs-10 right">
            <h1>问题详情</h1>
            <div class="imgg">
                <img src="<?php echo ($teacherquestiontab["que_img"]); ?>">
            </div>
            <div class="row content-righh">
                <div class="col-md-2 col-xs-2 lefttt">
                    <h1>问题标题：</h1>
                </div>
                <div class="col-md-10 col-xs-10 rightww">
                    <p><?php echo ($teacherquestiontab["que_title"]); ?></p>
                </div>
            </div>
            <div class="row content-righh">
                <div class="col-md-2 col-xs-2 lefttt">
                    <h1>问题详情：</h1>
                </div>
                <div class="col-md-10 col-xs-10 rightww">
                    <p><?php echo ($teacherquestiontab["que_content"]); ?></p>
                </div>
            </div>
            <div class="row content-righh">
                <div class="col-md-2 col-xs-2 lefttt">
                    <h1>分类标签：</h1>
                </div>
                <div class="col-md-10 col-xs-10 rightww">
                    <p><?php echo ($teacherquestiontab["que_tab"]); ?></p>
                </div>
            </div>
            
            
            <div class="row content-righh">
                <div class="col-md-2 col-xs-2 lefttt">
                    <p></p>
                </div>
                <div class="col-md-10 col-xs-10 rightww">
                    <div class="buttongroup">
                        <form action="">
                            <a href="javascript:history.go(-1)" class="button1">上传问题</a>
                            
                            <a href="javascript:history.go(-1)" class="button2">返回</a>
                            
                        </form>
                    </div>
                </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script src="/topstudent/Public/admin/js/jquery.min.js"></script>
<script src="/topstudent/Public/admin/js/bootstrap.min.js"></script>
<script src="/topstudent/Public/admin/js/scripts.js"></script>
</body>
</html>