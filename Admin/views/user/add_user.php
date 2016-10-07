<form action="<?php echo \Admin\url('user/addUserPost'); ?>" method="post" id="userAddPost" autocomplete="off">
	<fieldset>
		<label for="username">用户名</label>
		<div class="input-control text size4" data-role="input-control">
	      <input type="text" name="username" id="username" placeholder="用户名" required />
	      <button class="btn-clear" tabindex="-1" type="button"></button>
		</div>
		<label for="password">密码</label>
		<div class="input-control password size4" data-role="input-control">
	      <input type="password" name="password" id="password" placeholder="密码" required />
	      <button class="btn-reveal" tabindex="-1" type="button"></button>
		</div>
		<label for="role">角色</label>
		<div class="input-control text size4" data-role="input-control">
	      <input type="text" name="role" id="role" placeholder="角色" list="rolelist" required />
	      <datalist id="rolelist">
			<option label="管理员" value="admin" />
			<option label="编辑" value="editor" />
			<option label="待定" value="nologin" />	      	
	      </datalist>
		</div>
		<label for="isvalid">是否可用</label>
		<div class="input-control select size4">
	     	<select name="isvalid" id="isvalid"  required>
				<option value="0">不可用</option>
				<option value="1" selected>可用</option>
			</select>
		</div>
      	<button type="button" class="primary" onclick="f.submit('#userAddPost')">提交</button>
	</fieldset>
</form>