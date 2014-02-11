<blockquote class="block-title">其它 · 文章分类</blockquote>
<div class="page-section">
	<div class="toolbar transparent">
	    <div class="toolbar-group">
	        <button data-event="article.category.add"><i class="icon-plus"></i> 添加</button>
	        <button><i class="icon-remove"></i> 删除</button>
	        <button><i class="icon-folder-2"></i> 编辑</button>
	    </div>
	</div>
	<table class="table hovered">
		<thead>
			<tr>
				<th class="text-left">ID</th>
				<th class="text-left">分类名称</th>
				<th class="text-left">是否可用</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($categories as $cat):?>
				<tr>
					<td><?php echo $cat['id'];?></td>
					<td><?php echo $cat['name'];?></td>
					<td><?php echo $cat['isvalid'] == 1 ? '是' : '否';?></td>
				</tr>
			<?php endforeach;?>
		</tbody>
	</table>
</div>
