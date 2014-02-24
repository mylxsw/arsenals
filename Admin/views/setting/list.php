<?php \Admin\block_header('配置'); ?>
<div class="page-section">
	<div class="toolbar transparent">
	    <div class="toolbar-group">
	        <button data-event="setting.add"><i class="icon-plus"></i> 添加</button>
	        <button data-event="setting.del"><i class="icon-remove"></i> 删除</button>
	        <button data-event="setting.edit"><i class="icon-folder-2"></i> 编辑</button>
	    </div>
	</div>
	<table class="table hovered" id="setting_table">
		<thead>
			<tr>
				<th class="text-left" style="width: 50px;"><a href="#" data-event="g.select_all">选择</a></th>
				<th class="text-left">名称</th>
				<th class="text-left">用途</th>
				<th class="text-left">命名空间</th>
				<th class="text-left">是否序列化</th>
				<th class="text-left">是否可用</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($settings as $se):?>
				<tr>
					<td><input type="checkbox" name="id" class="select_all_item" value="<?php echo $se['id'];?>" /></td>
					<td><?php echo $se['setting_key'];?></td>
					<td><?php echo $se['info'];?></td>
					<td><?php echo $se['namespace'];?></td>
					<td style='font-weight:bold;'><?php echo $se['isserialise'] == 1 ? '<span style="color: green">是</span>' : '<span style="color: red">否</span>'; ?></td>
					<td><?php echo $se['isvalid'] == 1 ? '<span style="color: green">是</span>' : '<span style="color: red">否</span>';?></td>
				</tr>
			<?php endforeach;?>
		</tbody>
	</table>
</div>