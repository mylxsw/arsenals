<?php \Admin\block_header('编辑文章'); ?>
<form action="<?php echo \Admin\url('article/editPost'); ?>" method="post" id="o-form-edit-article" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?php echo $art['id']; ?>" />
	<fieldset>
		<label for="blog_title">标题</label>
		<div class="input-control text size4" data-role="input-control">
	      <input type="text" name="blog_title" id="blog_title" placeholder="标题" value="<?php echo $art['title']; ?>" />
	      <button class="btn-clear" tabindex="-1" type="button"></button>
		</div>
		<label for="category">分类 (Ctrl多选)</label>
		<div class="input-control select size4">
			<?php $_cats = \Admin\category($art['id'], false); ?>
	     	<select name="category_id[]" id="category" multiple >
				<?php foreach ($categorys as $k => $v): ?>
					<option value="<?php echo $v['id']; ?>" <?php echo in_array($v['id'], $_cats) ? 'selected' : ''; ?> ><?php echo $v['name']; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
        <label for="sources">来源</label>
     	<div class="input-control text size3">
            <input type="text" name="sources" list="sources_list" value="<?php echo $art['source']; ?>" />
            <?php echo \Admin\article_source_list('sources_list'); ?>
		</div>
	     	
		<label for="tag">标签</label>
		<div class="input-control text size4">
		   <input type="text" name="tag" id="tag" placeholder="标签" value="<?php echo \Admin\tags($art['id']); ?>"/>
		   <button class="btn-search o-toggle" data-target="#selectLabels"></button>
		</div>
		<div class="o-hide" id="selectLabels">
			<?php foreach ($tags as $k => $v): ?>
				<a href="<?php echo $v['name']; ?>" class="o-add-label direct" data-target="#tag">
					<?php echo $v['name']; ?>
				</a>
			<?php endforeach; ?>
		</div>
		<label for="blog_intro">内容概要 </label>
		<div class="input-control textarea size8">
		    <textarea name="intro" id="blog_intro" placeholder="内容概要" ><?php echo $art['intro']; ?></textarea>
		</div>
		<label for="blog_textarea">文章正文 </label>
		<div class="input-control textarea size 10">
		    <script name="blog_textarea"  type="text/plain" id="blog_textarea"><?php echo $art['content']; ?></script>
		</div>
		<label for="feature_img">封面图片 <a href="#" data-event="blog.select_image_cover">选择</a></label>
		<div class="input-control file size4" data-role="input-control">
			<input type="file" name="feature_img" id="feature_img" data-role="input-control" />
            <input type="hidden" name="feature_img_selected" />
			<button class="btn-file"></button>
		</div>
		<div id="feature_img_area" class="image-container"></div>
		<div class="o-clear"></div>
      	<button type="button" class="primary" onclick="f.submit('#o-form-edit-article')" >提交</button>
	</fieldset>
</form>
<script src="<?php \Admin\public_resource_path(); ?>ueditor/ueditor.config.js"></script>
<script src="<?php \Admin\public_resource_path(); ?>ueditor/ueditor.all.min.js"></script>
<script type="text/javascript">
window.UM = UE.getEditor('blog_textarea');
$.Metro.initInputs();
$(function(){
	var feature_img = "<?php echo \Admin\url($art['feature_img']); ?>";
	if (feature_img != '') {
		$("#feature_img_area").html("<img src='" + feature_img + "' class='span4' /><div class=\"overlay-fluid\">" + feature_img + "</div>");
	};
});	
</script>