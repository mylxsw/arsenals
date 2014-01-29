<nav class="sidebar light">
    <script>
		$(function(){
			var nav_json = <?php echo json_encode($nav);?>;
			// 设置顶部导航触发侧栏导航
			$("#top-nav").delegate("a", "click", function(e){
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
				e.preventDefault();
			});
			// 模拟触发点击第一项
			$("#top-nav a:first").trigger("click");
			// 侧栏菜单事件绑定
			$("#left-sidebar").delegate("a", "click", function(e){
				e.preventDefault();
				$("#left-sidebar li").removeClass("active");
				$(this).parent("li").addClass("active");

				f.page_update("#main-area", $(this).attr("href"), true);
			});
			$("#left-sidebar a:first").trigger("click");
			
		});
    </script>
    <ul id="left-sidebar"></ul>
</nav>