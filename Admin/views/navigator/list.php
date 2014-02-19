<?php \Admin\block_header('导航'); ?>
<div class="page-section">
	<div class="toolbar transparent">
	    <div class="toolbar-group">
	        <button data-event="navigator.add"><i class="icon-plus"></i> 添加</button>
	        <button data-event="navigator.del"><i class="icon-remove"></i> 删除</button>
	        <button data-event="navigator.edit"><i class="icon-folder-2"></i> 编辑</button>
	    </div>
	</div>
	<table class="table hovered" id="navigator_table">
		<thead>
			<tr>
				<th class="text-left" style="width: 50px;"><a href="#" data-event="g.select_all">选择</a></th>
				<th class="text-left">名称</th>
				<th class="text-left">地址</th>
				<th class="text-left">排序</th>
				<th class="text-left">位置</th>
				<th class="text-left">是否可用</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($navs as $nav):?>
				<tr>
					<td><input type="checkbox" name="id" class="select_all_item" value="<?php echo $nav['id'];?>" /></td>
					<td><?php echo $nav['name'];?></td>
					<td><?php echo $nav['url'];?></td>
					<td><?php echo $nav['sort'];?></td>
					<td style='font-weight:bold;'><?php echo $nav['pos'];?></td>
					<td><?php echo $nav['isvalid'] == 1 ? '<span style="color: green">是</span>' : '<span style="color: red">否</span>';?></td>
				</tr>
				<?php  $sub_nav = $navModel->listByCondition(array('pid'=> $nav['id'], 'pos'=>$nav['pos'])); ?>
				<?php if (!is_null($sub_nav) && count($sub_nav) > 0):?>
					<?php foreach ($sub_nav as $sn):?>
						<tr>
							<td><input type="checkbox" name="id" class="select_all_item" value="<?php echo $sn['id'];?>" /></td>
							<td style="color:#999"><?php echo '&nbsp;&nbsp;&nbsp;&nbsp;->' , $sn['name'];?></td>
							<td><?php echo $sn['url'];?></td>
							<td><?php echo $sn['sort'];?></td>
							<td style='font-weight:bold;'><?php echo $sn['pos'];?></td>
							<td><?php echo $sn['isvalid'] == 1 ? '<span style="color: green">是</span>' : '<span style="color: red">否</span>';?></td>
						</tr>
					<?php endforeach;?>
				<?php endif;?>
			<?php endforeach;?>
		</tbody>
	</table>
</div>