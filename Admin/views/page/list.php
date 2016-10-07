<?php \Admin\block_header('所有页面'); ?>
<div class="page-section">
	<div class="toolbar transparent">
	    <div class="toolbar-group">
	        <button data-event="page.add"><i class="icon-plus"></i> 添加</button>
	        <button data-event="page.del"><i class="icon-remove"></i> 删除</button>
	        <button data-event="page.edit"><i class="icon-folder-2"></i> 编辑</button>
	    </div>
	</div>
	<table class="table hovered" id="page_table">
		<thead>
			<tr>
				<th class="text-left" style="width: 50px;"><a href="#" data-event="g.select_all">选择</a></th>
				<th class="text-left">ID</th>
				<th class="text-left">页面名称</th>
				<th class="text-left">是否可用</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($pages as $p):?>
				<tr>
					<td><input type="checkbox" name="id" class="select_all_item" value="<?php echo $p['id']; ?>" /></td>
					<td><?php echo $p['id']; ?></td>
					<td><?php echo $p['title']; ?></td>
					<td><?php echo $p['isvalid'] == 1 ? '是' : '否'; ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>