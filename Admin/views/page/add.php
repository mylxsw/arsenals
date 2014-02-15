<?php \Admin\block_header('新增页面');?>
<div class="page-section">
	<form action="<?php echo \Admin\url('page/addPost');?>" method="post" id="add-new-page">
		<fieldset>
			<label for="title">页面标题</label>
			<div class="input-control text size4" data-role="input-control">
		      <input type="text" name="title" id="title" placeholder="页面标题" />
		      <button class="btn-clear" tabindex="-1" type="button"></button>
			</div>
			<label for="template">页面模板</label>
			<div class="input-control textarea size9">
		    	<textarea name="templates" id="templates" style="min-height: 200px;" placeholder="页面模板" ></textarea>
			</div>
			<div class="o-clear"></div>
			<button type="button" class="primary" onclick="f.submit('#add-new-page')">提交</button>
		</fieldset>
	</form>
</div>