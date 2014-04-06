<?php \Admin\block_header('用户');?>
<div class="page-section">
	<div class="toolbar transparent">
	    <div class="toolbar-group">
	        <button data-event="user.add"><i class="icon-plus"></i> 添加</button>
	        <button data-event="user.del"><i class="icon-remove"></i> 删除</button>
	        <button data-event="user.edit"><i class="icon-folder-2"></i> 编辑</button>
	    </div>
	</div>
	<table class="table hovered" id="user_table">
		<thead>
			<tr>
				<th class="text-left" style="width: 50px;"><a href="#" data-event="g.select_all">选择</a></th>
				<th class="text-left">ID</th>
				<th class="text-left">用户名</th>
				<th class="text-left">角色</th>
				<th class="text-left">是否可用</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($users as $user):?>
				<tr>
					<td><input type="checkbox" name="id" class="select_all_item" value="<?php echo $user['id'];?>" /></td>
					<td><?php echo $user['id'];?><?php if($current_user['username'] == $user['username']): ?> <span class="icon-locked" title="当前用户"></span><?php endif;?></td>
					<td><?php echo $user['username'];?></td>
					<td><?php echo $user['role'];?></td>
					<td><?php echo $user['isvalid'] == 1 ? '是' : '否';?></td>
				</tr>
			<?php endforeach;?>
		</tbody>
	</table>
</div>
