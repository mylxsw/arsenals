<blockquote class="block-title">其它 · 文章分类</blockquote>
<div class="page-section">
	<div class="toolbar transparent">
	    <div class="toolbar-group">
	        <button data-event="article.category.add"><i class="icon-plus"></i> 添加</button>
	        <button data-event="article.category.del"><i class="icon-remove"></i> 删除</button>
	        <button data-event="article.category.edit"><i class="icon-folder-2"></i> 编辑</button>
	    </div>
	</div>
	<table class="table hovered" id="category_table">
		<thead>
			<tr>
				<th class="text-left" style="width: 50px;"><a href="#" data-event="g.select_all">选择</a></th>
				<th class="text-left">ID</th>
				<th class="text-left">分类名称</th>
				<th class="text-left">是否可用</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($categories as $cat):?>
				<tr>
					<td><input type="checkbox" name="id" class="select_all_item" value="<?php echo $cat['id']; ?>" /></td>
					<td><?php echo $cat['id']; ?></td>
					<td><?php echo "<a href='" , \Admin\url("article/lists?cat={$cat['id']}") ,"'>{$cat['name']}</a>"; ?></td>
					<td><?php echo $cat['isvalid'] == 1 ? '是' : '否'; ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
