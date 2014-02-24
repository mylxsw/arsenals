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
		// 清空缓存
		clear_cache: function(){
			f.async('cache/clear', {}, function(data){
				f.tip(data.info, data.status == 1 ? 'success':'error');
			});
		},
		// 退出系统
		exit: function(){
			f.confirm("您确定要退出系统？", function(){
				f.async('account/logout', {}, function(data){
					f.tip(data.info, data.status == 1 ? 'success':'error');
					if(data.status == 1){
						window.setTimeout(function(){
							window.location.href= f.parseUrl('account/login');
							}, 1000);
					}
				});
			});
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
		},
		// 统一删除操作
		del: function(table_id, url){
			var ids = $(table_id).find('input.select_all_item:checked').map(function(){
				return $(this).val();
			}).get().join(",");

			if(ids == ''){
				return f.alert("请选择要删除的项!");
			}
			f.confirm("确定要删除这些项？", function(){
				f.async(url, {ids: ids}, function(data){
					f.tip(data.info, data.status == 1 ? 'success':'error');
					if(data.status == 1){
						o_fn.g.refresh();
					}
				}, 'post');
			});
		}
	},
	// 一次性事件
	once: function(){
		
	},
	// 文章管理相关
	article: {
		del: function(){
			o_fn.g.del('#article_table', 'article/del');
		},
		edit: function(){
			var id = $("#article_table").find('input.select_all_item:checked');
			if(id.length != 1){
				return f.alert("请选择一个要编辑的项!");
			}

			f.page_update("#main-area", 'article/edit??id=' + id.val());
		},
		// 清理文章缓存
		clear_cache: function(){
			var ids = $('#article_table').find('input.select_all_item:checked').map(function(){
				return $(this).val();
			}).get().join(",");

			if(ids == ''){
				return f.alert("请选择要清理的项!");
			}
			
			f.async('cache/clear_article_cache', {ids: ids}, function(data){
				f.tip(data.info, data.status == 1 ? 'success':'error');
			}, 'get');

		},
		// 文章分类
		category: {
			// 添加分类
			add: function(){
				f.dialog('article/categoryAdd', "添加分类", {}, function(){
				});
			},
			// 编辑分类
			edit: function(){
				var id = $("#category_table").find('input.select_all_item:checked');
				if(id.length != 1){
					return f.alert("请选择一个要编辑的项!");
				}
				f.dialog('article/categoryEdit', "编辑分类", {id: id.val()}, function(){

				});
			},
			// 删除分类
			del: function(){
				o_fn.g.del('#category_table', 'article/categoryDel');
			}
		}
	},
	page:{
		// 添加
		add: function(){
			f.page_update("#main-area", 'page/add');
		},
		// 编辑
		edit: function(){
			var id = $("#page_table").find('input.select_all_item:checked');
			if(id.length != 1){
				return f.alert("请选择一个要编辑的项!");
			}

			f.page_update("#main-area", 'page/edit??id=' + id.val());
		},
		// 删除
		del: function(){
			o_fn.g.del('#page_table', 'page/del');
		}
	},
	navigator: {
		add: function(){
			f.dialog('navigator/add', "添加导航", {}, function(){
			});
		},
		del: function(){
			o_fn.g.del('#navigator_table', 'navigator/del');
		}, 
		edit: function(){
			var id = $("#navigator_table").find('input.select_all_item:checked');
			if(id.length != 1){
				return f.alert("请选择一个要编辑的项!");
			}
			f.dialog('navigator/edit', "编辑导航", {id: id.val()}, function(){

			});
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
	},
	setting: {
		add: function(){
			f.dialog('setting/add', "添加配置", {}, function(){
			});
		},
		del: function(){
			o_fn.g.del('#setting_table', 'setting/del');
		}, 
		edit: function(){
			var id = $("#setting_table").find('input.select_all_item:checked');
			if(id.length != 1){
				return f.alert("请选择一个要编辑的项!");
			}
			f.dialog('setting/edit', "编辑配置", {id: id.val()}, function(){

			});
		}
	}
};