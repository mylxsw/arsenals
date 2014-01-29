$(function(){
	// 内容区域事件委派绑定
	$("#main-area").delegate(".o-toggle[data-target]", "click", function(e){
		if(e.target.tagName.toUpperCase() == 'A'){
			e.preventDefault();
		}
		//隐藏显示按钮绑定事件
		$($(this).attr("data-target")).slideToggle('fast');
		return false;
	}).delegate(".o-add-label[data-target]", "click", function(e){
		e.preventDefault();
		// 标签添加绑定事件
		var input = $($(this).attr("data-target"));
		input.val(
			(input.val() == '' ? 
				'' : (input.val() + ",")
			) 
			+ $(this).attr("href"));
	}).delegate("form", "submit", function(){
		return f.ajaxSubmit($(this));
	}).delegate("a[href!='#']:not(.direct)", "click", function(e){
		// 托管所有的链接事件，防止刷新页面
		e.preventDefault();
		f.page_update("#main-area", f.parseUrl($(this).attr("href")));
	}).delegate("a[href='#']", "click", function(e){
		// 托管所有#链接时间，进行不同事件处理
		e.preventDefault();
		var evt = $(this).attr("data-event").split('.');
		o_fn[evt[0]][evt[1]]($(this));
	}).delegate("select[data-event]", "change", function(){
		// select事件触发
		var evt = $(this).attr("data-event").split('.');
		o_fn[evt[0]][evt[1]]($(this));
	}).delegate("button[data-event]", "click", function(){
		// button按钮事件触发
		var evt = $(this).attr("data-event").split('.');
		o_fn[evt[0]][evt[1]]($(this));
	});
});