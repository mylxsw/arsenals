<form action="<?php echo \Admin\url('setting/addPost');?>" method="post" id="settingAddPost">
	<fieldset>
		<label for="setting_key">配置名称</label>
		<div class="input-control text size4" data-role="input-control">
	      <input type="text" name="setting_key" id="setting_key" placeholder="配置名称" required/>
	      <button class="btn-clear" tabindex="-1" type="button"></button>
		</div>

		<label for="setting_val">配置值 </label>
		<div class="input-control textarea size8">
		    <textarea name="setting_value" id="setting_val" placeholder="配置值" ></textarea>
		</div>

		<label for="info">备注信息</label>
		<div class="input-control text size4" data-role="input-control">
	      <input type="text" name="info" id="info" placeholder="备注信息" required/>
	      <button class="btn-clear" tabindex="-1" type="button"></button>
		</div>

		<label for="namespace">命名空间</label>
		<div class="input-control text size4" data-role="input-control">
	      <input type="text" name="namespace" id="namespace" placeholder="命名空间" required/>
	      <button class="btn-clear" tabindex="-1" type="button"></button>
		</div>

		<label for="setting_isserialise">是否序列化</label>
		<div class="input-control select size4">
	     	<select name="isserialise" id="setting_isserialise">
				<option value="0">否</option>
				<option value="1" selected>是</option>
			</select>
		</div>

		<label for="setting_isvalid">是否可用</label>
		<div class="input-control select size4">
	     	<select name="isvalid" id="setting_isvalid">
				<option value="0">不可用</option>
				<option value="1" selected>可用</option>
			</select>
		</div>
		
      	<button type="button" class="primary" onclick="f.submit('#settingAddPost')">提交</button>
	</fieldset>
</form>