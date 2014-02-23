<form action="<?php echo \Admin\url('navigator/editPost');?>" method="post" id="navigatorEditPost">
	<fieldset>
		<input type="hidden" name="id" value="<?php echo $nav['id'];?>" />
		<label for="nav_name">导航名称</label>
		<div class="input-control text size4" data-role="input-control">
	      <input type="text" name="name" id="nav_name" placeholder="导航名称" value="<?php \Admin\escape($nav['name']);?>" required/>
	      <button class="btn-clear" tabindex="-1" type="button"></button>
		</div>
		<label for="nav_url">导航地址</label>
		<div class="input-control text size4" data-role="input-control">
	      <input type="text" name="url" id="nav_url" placeholder="导航地址" value="<?php echo $nav['url'];?>" required/>
	      <button class="btn-clear" tabindex="-1" type="button"></button>
		</div>
		<label for="nav_pid">上级菜单</label>
		<div class="input-control select size4">
	     	<select name="pid" id="nav_pid" default="<?php echo $nav['pid']?>">
				<option value="0" selected>-- 没有上级 --</option>
				<?php foreach($navs as $nav):?>
					<option value="<?php echo $nav['id'];?>"><?php \Admin\escape($nav['pos']);?> - <?php \Admin\escape($nav['name']);?></option>
				<?php endforeach;?>
			</select>
		</div>
		<label for="nav_sort">排序 (值越大越靠前, 0-999)</label>
		<div class="input-control text size4" data-role="input-control">
	      <input type="text" name="sort" id="nav_sort" placeholder="排序" value="<?php echo $nav['sort'];?>" required/>
	      <button class="btn-clear" tabindex="-1" type="button"></button>
		</div>
		<label for="nav_pos">位置</label>
		<div class="input-control text size4" data-role="input-control">
	      <input type="text" name="pos" id="nav_pos" placeholder="位置" required value="<?php \Admin\escape($nav['pos']);?>"/>
	      <button class="btn-clear" tabindex="-1" type="button"></button>
		</div>
		<label for="nav_isvalid">是否可用</label>
		<div class="input-control select size4">
	     	<select name="isvalid" id="nav_isvalid" default="<?php echo $nav['isvalid'];?>">
				<option value="0">不可用</option>
				<option value="1" selected>可用</option>
			</select>
		</div>
		
      	<button type="button" class="primary" onclick="f.submit('#navigatorEditPost')">提交</button>
	</fieldset>
</form>