$(function(){
	// 初始化messenger消息框
	Messenger.options = {
	    extraClasses: 'messenger-fixed messenger-on-bottom messenger-on-right'
	};
	// 初始化主导航菜单
	$.getJSON(f.parseUrl("admin/services/navigation"), function(data){
		$("#o-top-nav").data('navigation', data);	

		// 委派主导航栏单击事件-激活侧边栏导航
		$("#o-top-nav").delegate("a", "click", function(e){
			var key = $(this).attr('href');
			if(f.contains(['main', 'articles', 'remarks', 'photos', 'pages', 'system'], key)){
				$("#o-top-nav li").removeClass("active");
				$(this).parent("li").addClass("active");
				var left_navs = $("#o-top-nav").data("navigation")[key];
				//alert(JSON.stringify(left_navs));
				var html = "";
				for(var n in left_navs){
					// 侧栏导航项
					var nav = left_navs[n];
					//alert(JSON.stringify(nav));
					// 如果id以#开头，说明含有子菜单
					if(n.indexOf('#') == 0){
						html += "<li><a href='" + n + "'>" + nav[0] + "</a><ul class=\"submenu dropdown\">";
						delete nav[0];
						for( var _n in nav){
							html += "<li><a href='" + nav[_n][1] + "'>" + nav[_n][0] + "</a></li>"; 
						}
						html += "</ul></li>";
					}else{
						html += "<li><a href='" + nav[1] + "'>" + nav[0] + "</a></li>";
					}
				}
				$("#o-left-nav").html(html);
				e.preventDefault();
			}
		});
		// 侧栏菜单委派事件，用于更新显示区域
		$("#o-left-nav").delegate("a", "click", function(e){
			e.preventDefault();
			$("#o-left-nav li").removeClass("active");
			$(this).parent("li").addClass("active");

			Messenger().hideAll();
			f.tip("页面加载中...");
			
			var link = f.parseUrl($(this).attr("href"));
			f.page_update("#main-area", link, true);
		});
		// 首页，触发首页侧栏菜单初始化
		$("#o-top-nav a[href='main']").trigger("click");

	});
	// 内容区域事件委派绑定
	$("#main-area").delegate(".o-toggle[data-target]", "click", function(e){
		//隐藏显示按钮绑定事件
		$($(this).attr("data-target")).slideToggle('fast');
		if(e.target.tagName.toUpperCase() == 'A'){
			e.preventDefault();
		}
	}).delegate(".o-add-label[data-target]", "click", function(e){
		// 标签添加绑定事件
		var input = $($(this).attr("data-target"));
		input.val(
			(input.val() == '' ? 
				'' : (input.val() + ",")
			) 
			+ $(this).attr("href"));
		e.preventDefault();
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