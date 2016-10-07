<?php \Admin\block_header('编辑模型'); ?>
<div class="page-section">
	<form action="<?php echo \Admin\url('document/doc_model_update_post'); ?>" method="post" id="docModelUpdatePost">
		<fieldset>
			<label for="model_name">名称</label>
			<div class="input-control text size4" data-role="input-control">
		      <input type="text" name="model_name" id="model_name" value="<?php echo $doc['model_name']; ?>" placeholder="名称" required/>
		      <button class="btn-clear" tabindex="-1" type="button"></button>
			</div>

			<label for="intro">用途 </label>
			<div class="input-control textarea size8">
			    <textarea name="intro" id="intro" placeholder="用途" ><?php echo $doc['intro']; ?></textarea>
			</div>

			<label for="tpl_edit">编辑模版 </label>
			<div class="input-control textarea size8">
			    <textarea name="tpl_edit" id="tpl_edit" placeholder="编辑模版" ><?php echo $doc['tpl_edit']; ?></textarea>
			</div>

			<label for="tpl_show">显示模版 </label>
			<div class="input-control textarea size8">
			    <textarea name="tpl_show" id="tpl_show" placeholder="显示模版" ><?php echo $doc['tpl_show']; ?></textarea>
			</div>

			<label for="setting">配置</label>
			<div class="input-control text size4" data-role="input-control">
		      <input type="text" name="setting" id="setting" placeholder="配置" value="<?php echo $doc['setting']; ?>" required/>
		      <button class="btn-clear" tabindex="-1" type="button"></button>
			</div>

			<label for="setting_isvalid">是否可用</label>
			<div class="input-control select size4">
		     	<select name="isvalid" id="setting_isvalid" default="<?php echo $doc['isvalid']; ?>">
					<option value="0">不可用</option>
					<option value="1" selected>可用</option>
				</select>
			</div>
			<input type="hidden" name="id" value="<?php echo $doc['id']; ?>" />
	      	<button type="button" class="primary" onclick="f.submit('#docModelUpdatePost')">提交</button>
		</fieldset>
	</form>
</div>