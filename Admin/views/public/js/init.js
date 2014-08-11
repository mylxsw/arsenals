$(function(){
	// 左侧导航以及顶部导航事件委派
	f.async("widget/slidebar", {}, function(nav_json){
		// 设置顶部导航触发侧栏导航
		$("#top-nav").undelegate("a", "click").delegate("a", "click", function(e){
			var key = $(this).attr('href');
			var left_navs = nav_json[key];
			var html = "";
			for(var n in left_navs){
				// 侧栏导航项
				var nav = left_navs[n];
				// 如果id以#开头，说明含有子菜单
				var li_class = f.cycle(['bg-red', 'bg-yellow', 'bg-green','bg-pink', 'bg-indigo', 'bg-emerald', 'bg-lime', 'bg-cobalt']);
				if(n.indexOf('#') == 0){
					html += "<li class='stick " + li_class + "'><a href='" + n + "' class='dropdown-toggle'>" + nav[0] + "</a><ul class=\"dropdown-menu\" data-role=\"dropdown\">";
					
					for( var _n in nav){
						if(_n == 0) continue;
						html += "<li><a href='" + nav[_n][1] + "'>" + nav[_n][0] + "</a></li>"; 
					}
					html += "</ul></li>";
				}else{
					html += "<li class='stick " + li_class + "'><a href='" + nav[1] + "'>" + nav[0] + "</a></li>";
				}
			}
			$("#left-sidebar").html("<li class='title'>" + $(this).html() + "</li>" + html);
			$.Metro.initDropdowns();
			e.preventDefault();
		});
		// 模拟触发点击第一项
		$("#top-nav a:first").trigger("click");
		// 侧栏菜单事件绑定
		$("#left-sidebar").undelegate("a", "click").delegate("a", "click", function(e){
			e.preventDefault();
			$("#left-sidebar li").removeClass("active");
			$(this).parent("li").addClass("active");

			f.page_update("#main-area", $(this).attr("href"), true);
		});
		$("#left-sidebar a:first").trigger("click");
	});

	// 初始化Metro界面
	METRO_AUTO_REINIT = true;
	// 页面全局事件
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