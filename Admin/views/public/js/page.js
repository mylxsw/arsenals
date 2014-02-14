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
		},
		// 全选
		select_all: function(_this){
			var table = _this.parents('table');
			var is_checked = table.data('checked');
			
			if(typeof is_checked == 'undefined'){
				table.data('checked', false);
				is_checked = false;
			}

			table.find('input.select_all_item:checkbox').prop('checked', !is_checked);
			table.data('checked', !is_checked);
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
	// 文章管理相关
	article: {
		// 文章分类
		category: {
			// 添加分类
			add: function(){
				f.dialog('article/categoryAdd', "添加分类", {}, function(){
				});
			},
			// 删除分类
			del: function(){
				var ids = $("#category_table").find('input.select_all_item:checked').map(function(){
					return $(this).val();
				}).get().join(",");

				if(ids == ''){
					return f.alert("请选择要删除的项!");
				}

				f.async('article/categoryDel', {ids: ids}, function(data){
					f.alert(data.info, function(){
						if(data.status == 1){
							o_fn.g.refresh();
						}
					});
				}, 'post');
			}
		}
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
		}
	}
};