<?php Demo\views\ink\header();?>
<div>
	<?php echo Demo\views\ink\index_lunbo();?>
	<div>
		<div class="new-product push-left">
			<div class="np-title">本周咖啡<a class="more" href="<?php echo \Demo\views\ink\url("articles/lists/14.html");?>">More...</a></div>
			<div class="np-body">
				<?php $_new_good = \Demo\views\ink\new_blog(14);?>
				<?php if(is_array($_new_good) && count($_new_good) > 0 ): ?>
					<img src="<?php echo \Demo\views\ink\url($_new_good[0]['feature_img'] == '' ? 'Resources/uploads/noimg.jpg': $_new_good[0]['feature_img']);?>" />
					<p><a href="<?php echo \Demo\views\ink\url("articles/show/{$_new_good[0]['id']}.html" );?>"><?php echo $_new_good[0]['title'];?></a></p>
				<?php endif;?>
			</div>
		</div>
		<div class="new-activy pull-left">
			<div class="na-title">CD推荐<a class="more" href="<?php echo \Demo\views\ink\url('articles/lists/15.html');?>">More...</a></div>
			<?php $_new_activys = \Demo\views\ink\new_blog(15, 8);?>
			<div class="na-body">
			<?php foreach ($_new_activys as $_ak=>$_av):?>
				<div class="na-block">
					<img src="<?php echo \Demo\views\ink\url($_av['feature_img'] == '' ? 'Resources/uploads/noimg.jpg': $_av['feature_img']);?>" title="<?php echo $_av['title'];?>"/>
					<div class="nab-title"><a href="<?php echo \Demo\views\ink\url("articles/show/{$_av['id']}.html");?>" title="<?php echo $_av['title'];?>"><?php echo $_av['title'];?></a></div>
					<div class="ink-clear"></div>
				</div>
			<?php endforeach;?>
			</div>
		</div>
	</div>
	<div class="ink-clear"></div>
	<div class="ad"><!-- 底部广告部分 -->
		<a href="http://www.letv.com" target="_blank" title="乐视网"><img src="<?php echo \Demo\views\ink\url('Resources/uploads/leshi.jpg');?>" /></a>
		<a href="http://www.mingyangyingshi.com" target="_blank" title="青岛名扬影视传播有限公司"><img src="<?php echo \Demo\views\ink\url('Resources/uploads/mingyang.jpg');?>" /></a>
		<a href="http://www.chinawpc.com.cn" target="_blank" title="山东邹平三立特木塑复合材料有限公司"><img src="<?php echo \Demo\views\ink\url('Resources/uploads/sanlite.jpg');?>" /></a>
		<a href="http://www.csia.cc" target="_blank" title="中国创业咖啡联盟"><img src="<?php echo \Demo\views\ink\url('Resources/uploads/csia.jpg');?>" /></a>
		<a href="http://www.cntv.cn" target="_blank" title="中国网络电视台"><img src="<?php echo \Demo\views\ink\url('Resources/uploads/cntv.jpg');?>" /></a>
	</div>
</div>
<script>
require(['page/home'], function(home){
	home.slider_play();
});
</script>
<?php Demo\views\ink\footer();?>