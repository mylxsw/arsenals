<?php \Admin\block_header('编辑页面');?>
<div class="page-section">
	<form action="<?php echo \Admin\url('page/editPost');?>" method="post" id="edit-new-page">
		<fieldset>
			<input type="hidden" name="id" value="<?php echo $page['id'];?>" />
			<label for="title">页面标题</label>
			<div class="input-control text size4" data-role="input-control">
		      <input type="text" name="title" id="title" placeholder="页面标题"  value="<?php echo $page['title']?>"/>
		      <button class="btn-clear" tabindex="-1" type="button"></button>
			</div>
			<label for="template">页面模板</label>
			<div class="input-control textarea size9">
		    	<textarea name="templates" id="templates" style="min-height: 200px;" placeholder="页面模板" ><?php echo htmlentities($page['templates']);?></textarea>
		    	<div id="ace-editor"><?php echo htmlentities($page['templates']);?></div>
			</div>
			<div class="o-clear"></div>
			<button type="button" class="primary" onclick="f.submit('#edit-new-page')">提交</button>
		</fieldset>
	</form>
</div>
<script src="<?php \Admin\public_resources_path(); ?>ace/ace.js" type="text/javascript" charset="utf-8"></script>
<script>
    var editor = ace.edit("ace-editor");
    editor.setTheme("ace/theme/twilight");
    editor.getSession().setMode("ace/mode/javascript");
</script>