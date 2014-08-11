<?php \Admin\block_header('图库');?>
<div class="page-section">
	<div class="toolbar transparent">
	    <div class="toolbar-group">
	        <button data-url="photos/add"><i class="icon-plus"></i> 添加</button>
	        <button data-event="photo.del"><i class="icon-remove"></i> 删除</button>
	        <button data-event="photo.edit"><i class="icon-folder-2"></i> 编辑</button>
	    </div>
	</div>
	<table class="table hovered" id="photos_table">
		<thead>
			<tr>
				<th class="text-left" style="width: 50px;"><a href="#" data-event="g.select_all">选择</a></th>
				<th class="text-left">ID</th>
				<th class="text-left">标题</th>
				<th class="text-left">图片数量</th>
				<th class="text-left">标签</th>
				<th class="text-left">发布时间</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($photos['data'] as $pic):?>
				<tr>
					<td><input type="checkbox" name="id" class="select_all_item" value="<?php echo $pic['id'];?>" /></td>
					<td><?php echo $pic['id'];?></td>
					<td><?php echo $pic['title'];?></td>
					<td><?php echo $pic['c'];?></td>
					<td><?php echo \Admin\tags_str($pic['tag']);?></td>
					<td><?php echo date('Y-m-d H:i:s', $pic['create_time']);?></td>
				</tr>
			<?php endforeach;?>
		</tbody>
	</table>
	<?php echo \Admin\pagination('photos/lists' . (isset($tag) && !is_null($tag) ? "?tag={$tag}" : ''), $photos['total'], $photos['page'], $p); ?>
</div>