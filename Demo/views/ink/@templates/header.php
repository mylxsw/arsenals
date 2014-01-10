<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>C.D.Cafe</title>
	<meta name="description" content="">
	<meta name="author" content="ink, cookbook, recipes">
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
  	<link rel="stylesheet/less" type="text/css" href="<?php \Demo\views\ink\resource_path();?>css/custom.css" />
  	<link rel="stylesheet/less" type="text/css" href="<?php \Demo\views\ink\resource_path();?>css/style.css" />
	<script type="text/javascript" src="<?php \Demo\views\ink\public_resource_path();?>less-1.4.2.min.js" ></script>
</head>
<body data-resource="<?php \Demo\views\ink\public_resource_path();?>">
<div class="ink-grid" id="main">
	<header id="header">
		<h1><img src="http://115.29.39.240/wp-content/uploads/2013/12/%E5%92%96%E5%95%A1%E5%8E%85logo.png" /></h1>
		<nav class="ink-navigation vspace">
		<ul class="menu horizontal grey rounded ">
			<?php echo Demo\views\ink\top_nav($current_nav);?>
		</ul>
		</nav>
	</header>
	<div class="column-group" id="main-content">