<?php \Admin\block_header('编辑页面'); ?>
<div class="page-section">
	<form action="<?php echo \Admin\url('page/editPost'); ?>" method="post" id="edit-new-page">
		<fieldset>
			<input type="hidden" name="id" value="<?php echo $page['id']; ?>" />
			<label for="title">页面标题</label>
			<div class="input-control text size4" data-role="input-control">
		      <input type="text" name="title" id="title" placeholder="页面标题"  value="<?php echo $page['title']?>"/>
		      <button class="btn-clear" tabindex="-1" type="button"></button>
			</div>
			<label for="template">页面模板</label>
			<div class="input-control textarea size9">
		    	<?php \Admin\code_editor('templates', htmlspecialchars($page['templates'])); ?>
			</div>
			
			<div class="o-clear"></div>
			<button type="button" class="primary" onclick="f.submit('#edit-new-page')">提交</button>
		</fieldset>
	</form>
</div>
