<?php \Demo\views\ink\header();?>
	<?php echo \Demo\views\ink\breadcrumbs(isset($breadcrumbs) ? $breadcrumbs:array());?>
	<?php foreach ($articles as $art):?>
		<div class="article-list">
			<div class="picture"><img src="http://www.starbucks.com.cn/upload/news/20131021192704.jpg"/></div>
			<div class="content">
				<h5 class="title">
					<a href="<?php echo \Demo\views\ink\url('articles/show?id=' . $art['id']);?>">
						<?php echo $art['blog_title'];?>
					</a>
				</h5>
				<div class="intro"><?php echo \Demo\views\ink\htmlToText($art['blog_intro']);?></div>
			</div>
			<div class="ink-clear"></div>
		</div>
	<?php endforeach;?>
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