<blockquote class="block-title">配置</blockquote>
<div class="page-section">
	<table id="logTable" class="table striped hovered dataTable">
		<thead>
			<tr>
				<th>ID</th>
				<th>配置键</th>
				<th>命名空间</th>
				<th>备注</th>
				<th>是否可用</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>
</div>
<script src="<?php \Admin\public_resource_path();?>jquery/jquery.dataTables.js"></script>
<script type="text/javascript">
	$(function(){
		f.dataTable("#logTable",  "<?php echo \Admin\url('setting/async');?>");
	});
</script>