<blockquote class="block-title">日志</blockquote>
<div class="page-section">
	<table id="logTable" class="table striped hovered dataTable">
		<thead>
			<tr>
				<th class="text-left">ID</th>
				<th class="text-left">操作时间</th>
				<th class="text-left">操作</th>
				<th class="text-left">操作者</th>
				<th class="text-left">类型</th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>
</div>
<script src="<?php \Admin\public_resource_path();?>jquery/jquery.dataTables.js"></script>
<script type="text/javascript">
	$(function(){
		f.dataTable("#logTable",  "<?php echo \Admin\url('log/async');?>");
	});
</script>