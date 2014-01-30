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
	<header class="bg-dark" data-load="<?php echo \Admin\url('widget/header');?>"></header>
	<div id="main">
		<nav id="left-nav" data-load="<?php echo \Admin\url('widget/slidebar');?>"></nav>
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

	<script>
	$(function(){
	    $("[data-load]").each(function(){
	        $(this).load($(this).data("load"), function(){
	        });
	    });

	    $(".history-back").on("click", function(e){
	        e.preventDefault();
	        history.back();
	        return false;
	    });
	});
// 	function headerPosition(){
// 	    if ($(window).scrollTop() > $('header').height()) {
// 	        $("header .navigation-bar")
// 	            .addClass("fixed-top")
// 	            .addClass(" shadow")
// 	        ;
// 	    } else {
// 	        $("header .navigation-bar")
// 	            .removeClass("fixed-top")
// 	            .removeClass(" shadow")
// 	        ;
// 	    }
// 	}

// 	$(function() {
// 	    if ($('nav > .side-menu').length > 0) {
// 	        var side_menu = $('nav > .side-menu');
// 	        var fixblock_pos = side_menu.position().top;
// 	        $(window).scroll(function(){
// 	            if ($(window).scrollTop() > fixblock_pos){
// 	                side_menu.css({'position': 'fixed', 'top':'65px', 'z-index':'1000'});
// 	            } else {
// 	                side_menu.css({'position': 'static'});
// 	            }
// 	        })
// 	    }
// 	});

// 	$(function(){
// 	    setTimeout(function(){headerPosition();}, 100);
// 	})

// 	$(window).scroll(function(){
// 	    headerPosition();
// 	});
	METRO_AUTO_REINIT = true;
	</script>
</body>
</html>