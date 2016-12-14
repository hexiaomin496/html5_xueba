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
        			<div id="collapseOne" class="panel-collapse collapse in">
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
        
		<div class="col-md-10 col-xs-10 right">
        	<h1>课本添加</h1>
            <div class="rightcon">
                
            	<img src="/topstudent/Public/<?php echo ($books['book_cover']);?>" width="148" alt="" />
                <form method="post" action="/topstudent/index.php/Admin/Books/save" enctype="multipart/form-data" name="books">
                <div class="bookpage">
                	<button class="buttonleft"></button>
                   
                    <div class="file-box">  
                        <input type='button' class='add' /> 
                        <input type="file" name="fileField[]" class="file file1" id="fileField" size="28"  accept="image/jpeg,image/gif,image/png" multiple/> 
                    </div>
                    
                    <div class="bookcon">
                    <img src="/topstudent/Public/<?php echo ($books["book_img"]); ?>" alt="">
                        <!-- <img src="images/bookpage.jpg" alt="">
                        <img src="images/bookpage.jpg" alt="">
                        <img src="images/bookpage.jpg" alt="">
                        <img src="images/bookpage.jpg" alt="">
                        <img src="images/bookpage.jpg" alt="">
                        <img src="images/bookpage.jpg" alt=""> --> 
                    </div>
                    <button class="buttonright"></button>
                </div>
                <div class="buttongroup">
                
                <input name="book_id" value="<?php echo ($books["book_id"]); ?>" style="display:none;">
                <input name="book_publish" value="<?php echo date('Y-m-d H:i:s');?>" style="display:none;">
                <table class="form">

                	<tr>
                    	<td style="width:86px;">课本标题：</td>
                        <td><input type="text" value="" name="book_title"></td>
                    </tr>
                    <tr>
                    	<td>课本简介：</td>
                        <td rowspan="2"><textarea name="book_content"></textarea></td>
                    </tr>
                    <tr>
                    	<td>&nbsp;</td> 
                    </tr>
                    <tr>
                    	<td>分类标签：</td>
                        <td><select name="book_type">
                			<option>语文</option>
                            <option>数学</option>
                            <option>英语</option>
                		</select></td>
                    </tr>
                    <tr>
                    	<td>&nbsp;</td>
                        <td><button type="submit" class="btn button" >保存</button> </td>
                    </tr>
                </table> 
                 </form>  
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