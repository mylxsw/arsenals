<?php \Admin\block_header('文档模型'); ?>
<div class="page-section">
	<div class="toolbar transparent">
	    <div class="toolbar-group">
	        <button data-event="document_model.add"><i class="icon-plus"></i> 添加</button>
	        <button data-event="document_model.del"><i class="icon-remove"></i> 删除</button>
	        <button data-event="document_model.edit"><i class="icon-folder-2"></i> 编辑</button>
	    </div>
	</div>
	<table class="table hovered" id="doc_model_table">
		<thead>
			<tr>
				<th class="text-left" style="width: 50px;"><a href="#" data-event="g.select_all">选择</a></th>
				<th class="text-left">名称</th>
				<th class="text-left">用途</th>
				<th class="text-left">是否可用</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($docs as $se):?>
				<tr>
					<td><input type="checkbox" name="id" class="select_all_item" value="<?php echo $se['id'];?>" /></td>
					<td><?php echo $se['model_name'];?></td>
					<td><?php echo $se['intro'];?></td>
					<td><?php echo $se['isvalid'] == 1 ? '<span style="color: green">是</span>' : '<span style="color: red">否</span>';?></td>
				</tr>
			<?php endforeach;?>
		</tbody>
	</table>
</div>