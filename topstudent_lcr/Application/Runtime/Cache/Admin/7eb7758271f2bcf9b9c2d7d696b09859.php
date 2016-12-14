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
                                <li><a href="<?php echo U('Admin/books/index');?>">课本管理</a></li>
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
                    <div id="collapseTwo" class="panel-collapse collapse in">
                        <div class="panel-body">
                            <ul>
                                <li class="linow"><a href="<?php echo U('Admin/questions/index');?>">问题审核</a></li>
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
                                <li><a href="<?php echo U('Admin/user/index');?>">用户列表</a></li>
                                <li><a href="<?php echo U('Admin/user/teacher');?>">教师管理</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <form action="<?php echo U('Admin/questions/index');?>" method="post">
		<div class="col-md-10 col-xs-10 right">
            <h1>问题详情</h1>
            <div class="imgg">
                <img src="<?php echo ($list["que_img"]); ?>">
            </div>
            <div class="row content-righh">
                <div class="col-md-2 col-xs-2 lefttt">
                    <h1>问题标题：</h1>
                </div>
                <div class="col-md-10 col-xs-10 rightww">
                    <p><?php echo ($list["title"]); ?></p>
                </div>
            </div>
            <div class="row content-righh">
                <div class="col-md-2 col-xs-2 lefttt">
                    <h1>问题详情：</h1>
                </div>
                <div class="col-md-10 col-xs-10 rightww">
                    <p><?php echo ($list["content"]); ?></p>
                </div>
            </div>
            <div class="row content-righh">
                <div class="col-md-2 col-xs-2 lefttt">
                    <h1>分类标签：</h1>
                </div>
                <div class="col-md-10 col-xs-10 rightww">
                    <p><?php echo ($list["pag"]); ?></p>
                </div>
            </div>
            
            
            <div class="row content-righh">
                <div class="col-md-2 col-xs-2 lefttt">
                    <p></p>
                </div>
                <div class="col-md-10 col-xs-10 rightww">
                    <div class="buttongroup">
                        <form action="">
                            <button  type="submit" class="btn button1">上传问题</button>
                            
                            <a href="<?php echo U('Admin/questions/index');?>" class="btn button2">返回</a>
                            
                        </form>
                    </div>
                </div>
                </div>
            </div>
        </div>
        </form>

    </div>
</div>
<script src="/topstudent/Public/admin/js/jquery.min.js"></script>
<script src="/topstudent/Public/admin/js/bootstrap.min.js"></script>
<script src="/topstudent/Public/admin/js/scripts.js"></script>
<script src="/topstudent/Public/admin/js/qiehuan.js"></script>
</body>
</html>