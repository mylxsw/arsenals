<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Arsenals后台管理</title>
	<meta name="description" content="">
	<meta name="author" content="ink, cookbook, recipes">
	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<link rel="stylesheet" type="text/css" href="<?php \Admin\public_resource_path()?>metro-ui-css/metro-bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php \Admin\public_resource_path()?>metro-ui-css/metro-bootstrap-responsive.min.css" />
	<link rel="stylesheet/less" type="text/css" href="<?php \Admin\resource_path()?>css/custom.less">
	<link rel="stylesheet/less" type="text/css" href="<?php \Admin\resource_path()?>css/style.less">

	<script src="<?php \Admin\public_resource_path()?>less-1.4.2.min.js"></script>
	<script type="text/javascript">
		var basePath = "<?php \Admin\resource_path()?>";
		window.UEDITOR_HOME_URL = basePath + "ueditor/";
	</script>
</head>
<body class="metro>
	<div id="topbar">
		<nav class="ink-navigation ink-grid">
			<h3>AgileDEV</h3>
            <ul class="menu horizontal flat blue shadowed" id="o-top-nav">
                <li class="active"><a href="main">主面板</a></li>
                <li><a href="articles">文章</a></li>
                <li><a href="remarks">评论</a></li>
                <li><a href="photos">相册</a></li>
                <li><a href="pages">页面</a></li>
                <li><a href="system">系统</a></li>
            	<li class="push-right"><a href="#">操作 <i class="icon-caret-down"></i></a>
            		<ul class="submenu">
            			<li><a href="<?php \Admin\url('rbac/account/logout')?>">退出</a></li>
            		</ul>
            	</li>
            </ul>
        </nav>
	</div>
	<div class="ink-grid" id="main">
		<nav class="ink-navigation" id="left-nav">
            <ul class="menu vertical black rounded shadowed" id="o-left-nav"></ul>
        </nav>
        <section id="main-area" class="white-box">
        	<div style="height: 600px; margin-top: 50px;">
        		<h1>What are you going to do?</h1>
        	</div>
        </section>
	</div>
	<footer class="screen-size-helper">
		<p class="title">Design By AgileDEV.pw</p>
	</footer>
	<script src="<?php \Admin\public_resource_path()?>jquery/jquery.min.js"></script>
	<script src="<?php \Admin\public_resource_path()?>jquery/jquery.widget.min.js"></script>
	<script src="<?php \Admin\public_resource_path()?>metro-ui-css/metro.min.js"></script>
	<script src="<?php \Admin\public_resource_path()?>jquery.form.js"></script>	

	<script src="<?php \Admin\public_resource_path()?>underscore-1.4.4.js"></script>
	<script src="<?php \Admin\public_resource_path()?>backbone.js"></script>

	<script src="<?php \Admin\resource_path()?>js/common.js"></script>
	<script src="<?php \Admin\resource_path()?>js/page.js"></script>
	<script src="<?php \Admin\resource_path()?>js/init.js"></script>
</body>
</html>