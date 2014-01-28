window.o_fn = {
	// 全局
	g:{
		// 返回
		back: function(){
			f.page_update("#main-area", $("#main-area").data("old-link"));
		}, 
		// 页面刷新
		refresh: function(){
			f.page_update("#main-area", $("#main-area").data("link"));
		}
	},
	// 一次性事件
	once: function(){
		// 检查是否存在博客发布表单，存在则自动保存草稿
		var autoSave = function(id, timeout){
			window.setTimeout(function(){
				// 如果存在该表单，则保存
				if($(id).length){
					// 如果编辑器存在内容则进行自动保存
					if(UM.hasContents()){
						f.ajaxSubmit($(id), function(){
							$(id).find("input[name=is_tmp]").val("1");
						}, function(data){
							if(data.status == 1){
								var form = $(id);
								form.attr("action", f.parseUrl('admin/blog/edit_blog'));
								form.find("input[name=act]").val("update");
								form.find("input[name=id]").val(data.data);
								
								f.tip("自动保存成功~", "success");
							}else{
								f.tip(data.info, "error");
							}
						});
					}

					
				}	
				autoSave(id, timeout);
			}, timeout);
		};
		//autoSave("#o-form-write-article", 90000);
	},
	// 归档页面
	archive: {
		category_show: function(){
			$("#select_category").slideToggle("fast");
		},
		tags_show: function(){
			$("#select_labels").slideToggle("fast");
		},
		select_all: function(){
		   f.select_all("blogs");
		},
		trans_to_category: function(_this){
			if(_this.val() == 'default')
	        	return false;
	      	f.table_ajax_action('admin/blog/blog_action', 'blogs', 'trans_category', '批量转移分类？', _this.val());
	      	_this.val('default');
		}
	},
	// 博客发布相关事件
	blog: {
		submit_to_blog: function(_this){
			var form = _this.parents("form");
			form.find("input[name=is_tmp]").val("0");
			form.trigger("submit");
		},
		save_to_tmp: function(_this){
			var form = _this.parents("form");
			form.find("input[name=is_tmp]").val("1");
			form.trigger("submit");
		}
	}
};