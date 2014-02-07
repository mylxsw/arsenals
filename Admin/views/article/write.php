<blockquote class="block-title">写文章</blockquote>
<form action="<?php echo \Admin\url('article/writePost');?>" method="post" id="o-form-write-article">
	<input type="hidden" name="id" value="" />
	<input type="hidden" name="act" value="" />
	<fieldset>
		<label for="blog_title">标题</label>
		<div class="input-control text size4" data-role="input-control">
	      <input type="text" name="blog_title" id="blog_title" placeholder="标题" />
	      <button class="btn-clear" tabindex="-1" type="button"></button>
		</div>
		<label for="category">分类</label>
		<div class="input-control select size4">
	     	<select name="category_id" id="category">
				<?php foreach($categorys as $k=>$v): ?>
					<option value="<?php echo $v['id'];?>"><?php echo $v['name']; ?></option>
				<?php endforeach;?>
			</select>
		</div>
		<label for="tag">标签</label>
		<div class="input-control text size4">
		   <input type="text" name="tag" id="tag" placeholder="标签"/>
		   <button class="btn-search o-toggle" data-target="#selectLabels"></button>
		</div>
		<div class="o-hide" id="selectLabels">
			<?php foreach ($tags as $k => $v): ?>
				<a href="<?php echo $v['name'];?>" class="o-add-label direct" data-target="#tag">
					<?php echo $v['name']; ?>
				</a>
			<?php endforeach;?>
		</div>
		<label for="blog_intro">内容概要 </label>
		<div class="input-control textarea size8">
		    <textarea name="intro" id="blog_intro" placeholder="内容概要" ></textarea>
		</div>
		<label for="blog_textarea">文章正文 </label>
		<div class="input-control textarea size 10">
		    <script name="blog_textarea"  type="text/plain" id="blog_textarea"></script>
		</div>
		
      	<button type="button" class="primary" data-event="blog.submit_to_blog" id="submit_to_blog">提交</button>
	</fieldset>
</form>
<script src="<?php \Admin\public_resource_path();?>ueditor/ueditor.config.js"></script>
<script src="<?php \Admin\public_resource_path();?>ueditor/ueditor.all.min.js"></script>
<script type="text/javascript">
window.UM = UE.getEditor('blog_textarea');
</script>