<?php \Admin\block_header('个人信息');?>
<form action="<?php echo \Admin\url('user/changePassword');?>" method="post" id="o-form-change-pwd" >
	<fieldset>
		<label for="username">用户名</label>
		<div class="input-control text size4" data-role="input-control">
	      <input type="text" name="username" id="username" placeholder="用户名" disabled="disabled" value="<?php echo $user['username'];?>" />
	      <button class="btn-clear" type="button"></button>
		</div>
		<label for="old_password">原始密码</label>
		<div class="input-control password size4" data-role="input-control">
	      <input type="password" name="old_password" id="old_password" placeholder="原始密码" required="required" />
	      <button class="btn-reveal"  type="button"></button>
		</div>
		<label for="new_password">新密码</label>
		<div class="input-control password size4" data-role="input-control">
	      <input type="password" name="new_password" id="new_password" placeholder="新密码" required="required" />
	      <button class="btn-reveal"  type="button"></button>
		</div>
		<label for="new_password_confirm">新密码确认</label>
		<div class="input-control password size4" data-role="input-control">
	      <input type="password" name="new_password_confirm" id="new_password_confirm" placeholder="新密码确认"  required="required"/>
	      <button class="btn-reveal"  type="button"></button>
		</div>

		<div class="o-clear"></div>
      	<button type="button" class="primary" onclick="f.submit('#o-form-change-pwd')" id="submit_change_password">提交</button>
	</fieldset>
</form>
