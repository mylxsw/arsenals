<?php \Admin\block_header('归档'); ?>
<div class="page-section">
	<div class="toolbar transparent">
	    <div class="toolbar-group">
	        <button data-url="article/write"><i class="icon-plus"></i> 添加</button>
	        <button data-event="article.del"><i class="icon-remove"></i> 删除</button>
	        <button data-event="article.edit"><i class="icon-folder-2"></i> 编辑</button>
	        <button data-event="article.clear_cache"><i class="icon-fire"></i> 清理缓存</button>
            <button data-event="article.ping"><i class="icon-paypal"></i> Ping</button>
	    </div>
	</div>
	<table class="table hovered" id="article_table">
		<thead>
			<tr>
				<th class="text-left" style="width: 50px;"><a href="#" data-event="g.select_all">选择</a></th>
				<th class="text-left">ID</th>
				<th class="text-left">标题</th>
				<th class="text-left">模型</th>
				<th class="text-left">分类</th>
                <th class="text-left">来源</th>
				<th class="text-left">发布时间</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($articles['data'] as $art):?>
				<tr>
					<td><input type="checkbox" name="id" class="select_all_item" value="<?php echo $art['id']; ?>" /></td>
					<td><?php echo $art['id']; ?></td>
					<td><?php echo $art['title']; ?></td>
					<td><?php echo $art['model']; ?></td>
					<td><?php echo \Admin\category($art['id']); ?></td>
                    <td><?php echo $art['source']; ?></td>
					<td><?php echo date('Y-m-d H:i:s', $art['publish_date']); ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php echo \Admin\pagination('article/lists'.(isset($cat) && !is_null($cat) ? "?cat={$cat}" : ''), $articles['total'], $articles['page'], $p); ?>
</div>