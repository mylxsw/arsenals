<blockquote class="block-title">其它 · 标签</blockquote>
<div class="page-section">
	<div class="toolbar transparent">
	    <div class="toolbar-group">
	        <button data-event="article.tag.add"><i class="icon-plus"></i> 添加</button>
	        <button data-event="article.tag.del"><i class="icon-remove"></i> 删除</button>
	        <button data-event="article.tag.edit"><i class="icon-folder-2"></i> 编辑</button>
	    </div>
	</div>
	<table class="table hovered" id="tag_table">
		<thead>
			<tr>
				<th class="text-left" style="width: 50px;"><a href="#" data-event="g.select_all">选择</a></th>
				<th class="text-left">ID</th>
				<th class="text-left">名称</th>
				<th class="text-left">是否可用</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($tags as $tag):?>
				<tr>
					<td><input type="checkbox" name="id" class="select_all_item" value="<?php echo $tag['id'];?>" /></td>
					<td><?php echo $tag['id'];?></td>
					<td><?php echo $tag['name'];?></td>
					<td><?php echo $tag['isvalid'] == 1 ? '是' : '否';?></td>
				</tr>
			<?php endforeach;?>
		</tbody>
	</table>
</div>
