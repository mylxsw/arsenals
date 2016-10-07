<form action="<?php echo \Admin\url('article/categoryEditPost'); ?>" method="post" id="categoryEditPost">
	<fieldset>
		<input type="hidden" name="id" value="<?php echo $cat['id']; ?>" />
		<label for="cate_name">分类名称</label>
		<div class="input-control text size4" data-role="input-control">
	      <input type="text" name="name" id="cate_name" placeholder="分类名称" value="<?php echo $cat['name']; ?>" />
	      <button class="btn-clear" tabindex="-1" type="button"></button>
		</div>
		
      	<button type="button" class="primary" onclick="f.submit('#categoryEditPost')">提交</button>
	</fieldset>
</form>