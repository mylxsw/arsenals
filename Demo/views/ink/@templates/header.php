<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>C.D.Cafe</title>
	<meta name="description" content="C.D.Cafe主页， 基于Arsenals框架开发">
	<meta name="author" content="mylxsw, code.404, ink, cookbook, recipes">
	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!--[if IE]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<link rel="stylesheet" type="text/css" href="<?php \Demo\views\ink\public_resource_path();?>ink/css/ink.css" />
  	<!--[if lte IE 7 ]>
  		<link rel="stylesheet" type="text/css" href="<?php \Demo\views\ink\public_resource_path();?>ink/css/ink-ie7.css" />
  	<![endif]-->
  	<?php foreach ($load_css as $key => $val):?>
  		<link rel="stylesheet" type="text/css" href="<?php \Demo\views\ink\public_resource_path();?><?php echo $val;?>" />
  	<?php endforeach;?>
  	<link rel="stylesheet/less" type="text/css" href="<?php \Demo\views\ink\resource_path();?>css/custom.css" />
  	<link rel="stylesheet/less" type="text/css" href="<?php \Demo\views\ink\resource_path();?>css/style.css" />
	<script type="text/javascript" src="<?php \Demo\views\ink\public_resource_path();?>less-1.4.2.min.js" ></script>
	
	<script type="text/javascript" src="<?php \Demo\views\ink\public_resource_path();?>ink/js/holder.js"></script>
	<script type="text/javascript" src="<?php \Demo\views\ink\public_resource_path();?>ink/js/ink.min.js"></script>
	<script type="text/javascript" src="<?php \Demo\views\ink\public_resource_path();?>ink/js/ink-ui.min.js"></script>
	<script type="text/javascript" src="<?php \Demo\views\ink\public_resource_path();?>ink/js/autoload.js"></script>
	<script type="text/javascript" src="<?php \Demo\views\ink\public_resource_path();?>require.js" ></script>
	<script type="text/javascript">
		var global = {
			view_resources_path: "<?php \Demo\views\ink\resource_path();?>",
			public_resources_path: "<?php \Demo\views\ink\public_resource_path();?>" 
		};
		require.config({
			baseUrl: global.view_resources_path + "js/",
			paths: {
				"jquery": global.public_resources_path + "jquery-1.8.3.min",
				"underscore": global.public_resources_path + "underscore-1.4.4",
				"backbone": global.public_resources_path + "backbone"
			}
		});
	</script>
</head>
<body>
<div class="ink-grid" id="main">
	<header id="header">
		<h1><img class="left-img" src="<?php \Demo\views\ink\resources();?>uploads/logo.png" /><img class="right-img" src="<?php \Demo\views\ink\resources();?>uploads/logo-right.jpg" /></h1>
		<nav class="ink-navigation vspace">
		<ul class="menu horizontal grey rounded ">
			<?php echo Demo\views\ink\top_nav(isset($current_nav) ? $current_nav : '');?>
		</ul>
		</nav>
	</header>
	<div class="column-group" id="main-content">