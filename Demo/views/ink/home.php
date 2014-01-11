<?php Demo\views\ink\header();?>
<div>
	<?php echo Demo\views\ink\index_lunbo();?>
	<div>
		<div class="new-product push-left">
			<div class="np-title">新品活动</div>
			<div class="np-body">
				<?php $_new_good = \Demo\views\ink\new_blog(3);?>
				<img src="<?php echo $_new_good[0]['feature_img'];?>" />
				<p><?php echo $_new_good[0]['title'];?></p>
			</div>
		</div>
		<div class="new-activy pull-left">
			<div class="na-title">最新活动</div>
			<?php $_new_activys = \Demo\views\ink\new_blog(2, 6);?>
			<div class="na-body">
			<?php foreach ($_new_activys as $_ak=>$_av):?>
				<div class="na-block">
					<img src="<?php echo $_av['feature_img'];?>" title="<?php echo $_av['title'];?>"/>
					<div class="nab-title"><a href="<?php echo $_av['id'];?>" title="<?php echo $_av['title'];?>"><?php echo $_av['title'];?></a></div>
					<div class="ink-clear"></div>
				</div>
			<?php endforeach;?>
			</div>
		</div>
	</div>
</div>
<script>
require(['page/home'], function(home){
	home.slider_play();
});
</script>
<?php Demo\views\ink\footer();?>