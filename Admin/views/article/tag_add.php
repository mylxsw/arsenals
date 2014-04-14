<form action="<?php echo \Admin\url('article/tagAddPost');?>" method="post" id="tagAddPost">
	<fieldset>
		<label for="tag_name">名称</label>
		<div class="input-control text size4" data-role="input-control">
	      <input type="text" name="name" id="tag_name" placeholder="名称" />
	      <button class="btn-clear" tabindex="-1" type="button"></button>
		</div>
		
      	<button type="button" class="primary" onclick="f.submit('#tagAddPost')">提交</button>
	</fieldset>
</form>