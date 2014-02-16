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
        </ul>
		<div class="no-tablet-portrait">
			<span class="element-divider"></span>
			<a class="element brand" href="#" onclick="o_fn.g.refresh()"><span class="icon-spin"></span></a>
			<span class="element-divider"></span>
			<div class="element place-right">
				<a class="dropdown-toggle" href="#">
					<span class="icon-cog"></span>
				</a>
				<ul class="dropdown-menu place-right" data-role="dropdown">
					<li>
						<a href="<?php echo \Admin\url('account/logout');?>" class="exit-sys">
							<span class="icon-exit">退出</span>
						</a>
					</li>
				</ul>
			</div>
			<span class="element-divider place-right"></span>
		</div>
    </div>
</div>
<script>
$(function(){
	$(".exit-sys").on("click", function(e){
		e.preventDefault();
		var that = $(this);
		f.confirm("您确定要退出系统？", function(){
			f.async(that.attr('href'), {}, function(data){
				f.tip(data.info, data.status == 1 ? 'success':'error');
				if(data.status == 1){
					window.setTimeout(function(){
						window.location.href="<?php echo \Admin\url('account/login');?>";
						}, 1000);
				}
			});
		});
	});
});
</script>