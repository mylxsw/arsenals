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
	<link rel="stylesheet/less" type="text/css" href="<?php \Admin\resource_path()?>css/custom.less">
	<link rel="stylesheet/less" type="text/css" href="<?php \Admin\resource_path()?>css/style.less">
	<link rel="stylesheet/less" type="text/css" href="<?php \Admin\resource_path()?>css/custom.less">
	<link rel="stylesheet/less" type="text/css" href="<?php \Admin\resource_path()?>css/style.less">

	<script src="<?php \Admin\public_resource_path()?>less-1.4.2.min.js"></script>
	<script type="text/javascript">
		var basePath = "<?php echo SITE_URL;?>";
		window.UEDITOR_HOME_URL = basePath + "Public/ueditor/";
	</script>
</head>
<body class="metro">
	<header class="bg-dark">
		<div class="navigation-bar dark">
		    <div class="navigation-bar-content container">
		        <a href="/" class="element"><span class="icon-grid-view"></span> AgileDEV <sup>dev</sup></a>
		        <span class="element-divider"></span>

		        <a class="element1 pull-menu" href="#"></a>
		        <ul class="element-menu" id="top-nav">
		            <li><a href="main">主面板</a></li>
		            <li><a href="articles">文章</a></li>
					<!--<li><a href="remarks">评论</a></li>
					<li><a href="photos">相册</a></li>-->
					<li><a href="pages">页面</a></li>
					<li><a href="system">系统</a></li>
					<li><a href="help">帮助</a></li>
		        </ul>
				<div class="no-tablet-portrait">
					<span class="element-divider"></span>
					<a class="element brand" href="#" onclick="o_fn.g.refresh()" title="刷新页面"><span class="icon-spin"></span></a>
					<a class="element brand" href="#" onclick="o_fn.g.clear_cache()" title="清空缓存"><span class="icon-fire"></span></a>
					<span class="element-divider"></span>
					<div class="element place-right">
						<a class="dropdown-toggle" href="#">
							<span class="icon-cog"></span>
						</a>
						<ul class="dropdown-menu place-right" data-role="dropdown">
							<li>
								<a href="#" class="exit-sys" onclick="o_fn.g.exit()" title="退出">
									<span class="icon-exit">退出</span>
								</a>
							</li>
						</ul>
					</div>
					<span class="element-divider place-right"></span>
				</div>
		    </div>
		</div>
	</header>
	<div id="main">
		<nav id="left-nav">
			<nav class="sidebar light">
			    <ul id="left-sidebar"></ul>
			</nav>
		</nav>
        <section id="main-area" class="white-box">
        	<div style="height: 600px; margin-top: 50px;">
        		<h1>你想要做点什么?</h1>
        	</div>
        </section>
	</div>
	<!-- <footer class="screen-size-helper">
		<p class="title">Design By AgileDEV.pw</p>
	</footer> -->
	<script src="<?php \Admin\public_resource_path()?>jquery/jquery.min.js"></script>
	<script src="<?php \Admin\public_resource_path()?>jquery/jquery.cookie.js"></script>
	<script src="<?php \Admin\public_resource_path()?>jquery/jquery.widget.min.js"></script>
	<script src="<?php \Admin\public_resource_path()?>metro-ui-css/metro.min.js"></script>
	<script src="<?php \Admin\public_resource_path()?>jquery.form.js"></script>	

	<script src="<?php \Admin\public_resource_path()?>underscore-1.4.4.js"></script>

	<script src="<?php \Admin\resource_path()?>js/common.js"></script>
	<script src="<?php \Admin\resource_path()?>js/page.js"></script>
	<script src="<?php \Admin\resource_path()?>js/init.js"></script>
</body>
</html>