<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="" />
		<title>随视管理后台</title>
        <link href="./Public/Admin/css/style.default.css?4.1" rel="stylesheet">
        <link href="./Public/Admin/css/bootstrap-timepicker.min.css?4.1" rel="stylesheet">
        <link href="./Public/Admin/css/bootstrap-override.css?4.1" rel="stylesheet">
        <link href="./Public/Admin/css/bootstrap-datetimepicker.css" rel="stylesheet">
        <link href="./Public/Admin/css/select2.css?4.1" rel="stylesheet">
        <link href="./Public/Admin/css/bootstrap-override.css?4.1" rel="stylesheet">
        <script src="./Public/Admin/js/jquery-1.11.1.min.js?4.1"></script>
        
         <style>
		.form-horizontal .control-label{ font-size:16px}
		</style>
        <link rel="stylesheet" href="./Public/Admin/kindeditor-4.1.10/themes/default/default.css" />
		
        
       
        <!--[if lt IE 9]>
        <script src="./Public/Admin/js/html5shiv.js?4.1"></script>
        <script src="./Public/Admin/js/respond.min.js?4.1"></script>
        <link href="./Public/Admin/css/ie.css?4.1" rel="stylesheet">
        <![endif]-->
    </head>
    <body>
	<header>
		<div class="headerwrapper">
			<div class="header-left">
 
				<div class="pull-right">
					<a class="menu-collapse" href="#">
						<i class="fa fa-bars"></i>
					</a>
				</div>
			</div>

			<div class="header-right" id="header_nav">
				<div class="header-profile">
					<div><?php echo $_SESSION['userInfo']['user_name']; ?>，欢迎登录!</div>
				</div>

				<div class="pull-right" id="pull-right">
					<div class="btn-group btn-group-option">
						<a href="<?php echo url('Login', 'logout', null, 'admin.php'); ?>" title="退出" class="btn btn-default dropdown-toggle"><i class="fa fa-sign-out"></i>退出</a>
					</div>
				</div>

				<div id="PT-marquee" class="pull-right" style="display: none;">
					<ul>
						<li><a href="javascript:;" class="readAdvice" id="already5241" data-id="5241" data-name="" data-food="0" data-title="" data-time="2015年02月03日" data-content='"\u6211\u7279\u70e6"'>【公告】1</a>
						</li>
                        <li><a href="javascript:;" class="readAdvice" id="already5241" data-id="5241" data-name="" data-food="0" data-title="" data-time="2015年02月03日" data-content='"\u6211\u7279\u70e6"'>【公告】2</a>
						</li>
					</ul>
				</div>

			</div>
			<!-- header-right -->
		</div>
		<!-- headerwrapper -->
	</header>

	<section>
		<div class="mainwrapper">
        <?php tpl('Admin.Common.menu');?>