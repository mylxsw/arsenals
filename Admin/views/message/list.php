<blockquote class="block-title">消息</blockquote>
<div class="page-section">
	<table id="messageTable" class="table striped hovered dataTable">
		<thead>
			<tr>
				<th class="text-left">ID</th>
				<th class="text-left">标题</th>
				<th class="text-left">内容</th>
				<th class="text-left">来源</th>
				<th class="text-left">类型</th>
                <th class="text-left">接收时间</th>
                <th class="text-left">是否已读</th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>
</div>
<script src="<?php \Admin\public_resource_path(); ?>jquery/jquery.dataTables.js"></script>
<script type="text/javascript">
	$(function(){
		f.dataTable("#messageTable",  "<?php echo \Admin\url('message/async'); ?>");
	});
</script>