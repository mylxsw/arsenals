<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>AgileDEV后台登陆</title>
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
	<div class="ribbed-cyan" id="login-body">
		<div id="login-area" class="ribbed-amber">
			<div class="box">
				<h1>AgileDEV<sup>1.0</sup></h1>
				<form id="login-form" action="<?php echo \Admin\url('account/loginPost');?>" method="post">
					<fieldset>
						<label for="account">账号:</label>
						<div class="input-control text size4">
							<input type="text" name="username" id="account" required placeholder="请输入账号" >
							<button class="btn-clear" tabindex="-1" type="button"></button>
						</div>
						<label for="password">密码:</label>
						<div class="input-control password size4">
							<input type="password" id="password" requried name="password" placeholder="请输入密码">
							<button class="btn-reveal" tabindex="-1" type="button"></button>
						</div>
						<div><button class="primary" id="login-btn" type="submit"><i class="icon-rocket on-left"></i>登陆</button></div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
	<footer class="screen-size-helper">
		<p class="title">Design By AgileDEV.pw</p>
	</footer>
	<script src="<?php \Admin\public_resource_path()?>jquery/jquery.min.js"></script>
	<script src="<?php \Admin\public_resource_path()?>jquery/jquery.widget.min.js"></script>
	<script src="<?php \Admin\public_resource_path()?>metro-ui-css/metro.min.js"></script>
	<script src="<?php \Admin\public_resource_path()?>jquery.form.js"></script>	


	<script src="<?php \Admin\resource_path()?>js/common.js"></script>
	<script src="<?php \Admin\resource_path()?>js/page.js"></script>
	<script>
		$(function(){
			var login_form = $("#login-form");

			login_form.ajaxForm({
				beforeSubmit: function(formData, jqForm, options){
					var username = $("input[name='username']");
					var password = $("input[name='password']");

					if(username.val() == "" || password.val() == ""){
						fn.alert("用户名或密码不能为空!");
						return false;
					}
				},
				success: function(data){
					f.tip(data.info, data.status == 1 ? 'success' : 'error');
					if(data.status == 1){
						window.setTimeout(function(){
							window.location.href='<?php echo \Admin\url('');?>';
						}, 3000);
					}
				},
				dataType: "json"
			});
		});
	</script>
</body>
</html>