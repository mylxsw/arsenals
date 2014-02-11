<form action="<?php echo \Admin\url('article/categoryAddPost');?>" method="post" id="categoryAddPost">
	<fieldset>
		<label for="blog_title">分类名称</label>
		<div class="input-control text size4" data-role="input-control">
	      <input type="text" name="name" id="cate_name" placeholder="分类名称" />
	      <button class="btn-clear" tabindex="-1" type="button"></button>
		</div>
		
      	<button type="button" class="primary" onclick="f.submit('#categoryAddPost')">提交</button>
	</fieldset>
</form>