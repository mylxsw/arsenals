$(function(){
    $("[data-load]").each(function(){
        $(this).load($(this).data("load"), function(){});
    });

	METRO_AUTO_REINIT = true;
	// 页面事件
	$("body").delegate("form", "submit", function(){
		return f.ajaxSubmit($(this));
	});
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
	}).delegate("a[href!='#']:not(.direct)", "click", function(e){
		// 托管所有的链接事件，防止刷新页面
		e.preventDefault();
		f.page_update("#main-area", f.parseUrl($(this).attr("href")));
	}).delegate("button[data-url]", "click", function(){
		var url = $(this).data('url');
		f.page_update("#main-area", f.parseUrl(url));
		return false;
	}).delegate("select[data-event]", "change", function(){
		// select事件触发
		var evt = $(this).attr("data-event");
		eval("o_fn." + evt + "($(this))");
	}).delegate("a[href='#'],button[data-event]", "click", function(e){

		if(e && e.preventDefault ) {
		　　//阻止默认浏览器动作(W3C)
		　　e.preventDefault();
		} else {
		　　//IE中阻止函数器默认动作的方式
		　　window.event.returnValue = false;
		}

		// button按钮事件触发
		var evt = $(this).attr("data-event");
		//o_fn[evt[0]][evt[1]]($(this));
		eval("o_fn." + evt + "($(this))");
	});
});