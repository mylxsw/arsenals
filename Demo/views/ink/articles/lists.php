<?php \Demo\views\ink\header();?>
<div id="main-left">
	<?php echo \Demo\views\ink\breadcrumbs(isset($breadcrumbs) ? $breadcrumbs:array());?>
	<?php foreach ($articles['data'] as $art):?>
		<div class="article-list">
			<div class="picture"><img src="<?php echo \Demo\views\ink\url($art['feature_img'] == '' ? 'Resources/uploads/noimg.jpg' : $art['feature_img']);?>"/></div>
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
	<?php if(count($articles['data']) == 0):?>
		<div>这里暂时没有文章哦~</div>
	<?php endif;?>
	<?php echo \Demo\views\ink\pagination('articles/lists/' . $cat, $articles['total'], $articles['page'], $p);?>
</div>
<script>
require(['page/home'], function(home){
	home.init();
});
</script>
<?php \Demo\views\ink\footer();?>