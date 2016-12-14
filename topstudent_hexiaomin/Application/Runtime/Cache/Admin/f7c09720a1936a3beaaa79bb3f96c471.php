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
    <link href="/topstudent/Public/admin/css/style2.css" rel="stylesheet">
</head>

<body>
<div class="container-fluid">
    <div class="row header">
        <h1>学霸养成后台管理系统<span><?php echo ($_SESSION['adm_username']); ?>&nbsp;<a href="/topstudent/index.php/Admin/Admins/logout">退出</a></a></span></h1>
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
                                <li><a href="<?php echo U('Admin/videos/index');?>">视频管理</a></li>
                                <li class="linow"><a href="<?php echo U('Admin/books/index');?>">课本管理</a></li>
                                <li><a href="<?php echo U('Admin/tests/index');?>">试卷管理</a></li>
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
                    <div id="collapseTwo" class="panel-collapse collapse">
                        <div class="panel-body">
                            <ul>
                                <li><a href="<?php echo U('Admin/questions/index');?>">问题审核</a></li>
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
                    <div id="collapseThree" class="panel-collapse collapse in">
                        <div class="panel-body">
                            <ul>
                                <li><a href="<?php echo U('Admin/user/index');?>">用户列表</a></li>
                                <li class="linow"><a href="<?php echo U('Admin/user/teacher');?>">教师管理</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title user">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">管理员管理</a>
                        </h4>
                    </div>
                    <div id="collapseFour" class="panel-collapse collapse ">
                        <div class="panel-body">
                            <ul>
                                <li><a href="<?php echo U('Admin/admins/index');?>">管理员列表</a></li>
                                <li><a href="<?php echo U('Admin/admins/add');?>">添加管理员</a></li>
                                <li><a href="<?php echo U('Admin/admins/edit');?>">个人密码修改</a></li>
                            </ul>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
		<div class="col-md-10 col-xs-10 right">
        	<h1>认证详情</h1>
            <div class="buttongroup">
            <div class="rightcon">
            	<img src="images/jszgz.jpg" width="290" height="219" alt="" class="jsimg"/>
                <div class="wz">
                	<div class="wzz">
                    	<h1>用户名:</h1>
                    	<h1>授课院校:</h1>
                    	<h1>学科分类:</h1>
                    </div>
                    <div class="wzr" name="teacher">

                        <h1><?php echo ($teacher["user_name"]); ?></h1>
                        <h1><?php echo ($teacher["tea_school"]); ?></h1>
                        <h1><?php echo ($teacher["tea_subject"]); ?></h1>
                    </div>
                </div>
                <div class="bts">
                	<a href="javascript:history.go(-1)" class="button">确认认证</a>
                    <a href="javascript:history.go(-1)" class="button">返回</a>
                </div>
            </div>
            </div>
        </div>
    </div>
    </div>
<script src="/topstudent/Public/admin/js/jquery.min.js"></script>
<script src="/topstudent/Public/admin/js/bootstrap.min.js"></script>
<script src="/topstudent/Public/admin/js/scripts.js"></script>
<script src="/topstudent/Public/admin/js/qiehuan.js"></script>
</body>
</html>