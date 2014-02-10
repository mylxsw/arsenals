<?php \Demo\views\ink\header();?>
<div id="main-left">
	<?php echo \Demo\views\ink\breadcrumbs(isset($breadcrumbs) ? $breadcrumbs:array());?>
	<div class="article">
		<h5 class="title"><?php echo $article['title'];?></h5>
		<div class="info"><?php echo $article['author']?> 发布于 <?php echo date('Y-m-d', $article['publish_date']);?> 
			<span class="ds-thread-count" data-thread-key="article_<?php echo $article['id'];?>" data-count-type="comments"></span>
		</div>
		<?php if (isset($article['tag']) && count($article['tag']) > 0): ?>
			<div class="tags">
				<?php foreach ($article['tag'] as $k=>$v):?>
					<?php echo $v['name'];?> 
				<?php endforeach;?>
			</div>
		<?php endif;?>
		<div class="content"><?php echo $article['content'];?></div>
		<?php if (isset($article['cate']) && count($article['cate']) > 0): ?>
			<div class="category">
			所属分类： 
				<?php foreach ($article['cate'] as $k=>$v):?>
					<?php echo "<span class='ink-badge black'>{$v['name']}</span>";?> 
				<?php endforeach;?>
			</div>
		<?php endif;?>
	</div>
	<?php \Demo\views\ink\remark($article['id']);?>
</div>

<script>
require(['page/home'], function(home){
	home.init();
});
</script>
<?php \Demo\views\ink\footer();?>