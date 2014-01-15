<?php \Demo\views\ink\header();?>
<div id="main-left">
	<?php echo \Demo\views\ink\breadcrumbs(isset($breadcrumbs) ? $breadcrumbs:array());?>
	<?php foreach ($articles['data'] as $art):?>
		<div class="article-list">
			<div class="picture"><img src="<?php echo \Demo\views\ink\url($art['feature_img']);?>"/></div>
			<div class="content">
				<h5 class="title">
					<a href="<?php echo \Demo\views\ink\url('articles/show?id=' . $art['id']);?>">
						<?php echo $art['title'];?>
					</a>
				</h5>
				<div class="intro"><?php echo \Demo\views\ink\htmlToText($art['intro']);?></div>
			</div>
			<div class="ink-clear"></div>
		</div>
	<?php endforeach;?>
	<?php echo \Demo\views\ink\pagination('articles/lists?cat=' . $cat, $articles['total'], $articles['page'], $p);?>
</div>
<div id="main-right">
右侧区域

</div>
<script>
require(['page/home'], function(home){
	home.init();
});
</script>
<?php \Demo\views\ink\footer();?>