<form action="<?php echo \Admin\url('article/tagEditPost');?>" method="post" id="tagEditPost">
	<fieldset>
		<input type="hidden" name="id" value="<?php echo $tag['id'];?>" />
		<label for="tag_name">名称</label>
		<div class="input-control text size4" data-role="input-control">
	      <input type="text" name="name" id="tag_name" placeholder="名称" value="<?php echo $tag['name'];?>" />
	      <button class="btn-clear" tabindex="-1" type="button"></button>
		</div>
		
      	<button type="button" class="primary" onclick="f.submit('#tagEditPost')">提交</button>
	</fieldset>
</form>