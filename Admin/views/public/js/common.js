/**
 * 常用函数库
 * @author 管宜尧
 * 2013-10-12
 */
window.f = {
	// Alert消息
	alert: function(message){
		alert(message);
	},
	// 提示消息
	// type : info , success, error
	tip: function(message, type){
		if(typeof type == "undefined"){
			type = "info";
		}
		$.globalMessenger().post({
			message: message,
			showCloseButton: true,
			type:type
		});
	},
	// 确认消息
	confirm: function(message, callback){
		if(confirm(message)){
			callback(true);
		}else{
			callback(false);
		}
	},
	/**
	 * 从数组中随机去一个值
	 * @param array
	 * @returns
	 */
	random: function(array){
		array.sort(function(){
			return Math.random() - 0.5;
		});
		return array[0];
	},
	/**
	 * 加载JS文件
	 * @param js
	 */
	load_js: function(js){
		var ds = document.createElement('script');
	    ds.type = 'text/javascript';
	    ds.async = true;
	    ds.src = js;
	    ds.charset = 'UTF-8';
	    (document.getElementsByTagName('head')[0]
	    	|| document.getElementsByTagName('body')[0]).appendChild(ds);
	},
	// 创建一个div
	create_div: function(id){
		var div = document.createElement('div');
		div.id = id;
		return div;
	},
	add_to_doc: function(div){
		document.getElementsByTagName('body')[0].appendChild(div);
	},
	parseUrl: function(url){
		if(url == ''){
			return basePath;
		}
		if(url.indexOf("http://") == 0 
				|| url.indexOf("https://") == 0 
				|| url.indexOf("ftp://") == 0 ){
			return url;
		}
		var suffix = ".html";
		var includedSuffix = url.indexOf(suffix) == (url.length - suffix.length);
		var params = url.split("??", 2);
		url = params[0];
		var return_val = "";
		if(url.indexOf("/") == 0){
			return_val= basePath + url.substring(1) + (includedSuffix ? "" : suffix) 
					+ (params.length == 2 ? ("?" + params[1] ) :  "");
		}else{
			return_val = basePath + url + (includedSuffix ? "" : suffix) + (params.length == 2 ? ("?" + params[1] ) : "" );
		}
		//var end_with_suffix = return_val.indexOf(suffix) == (return_val.length - suffix.length);
		//+ (end_with_suffix ? "?_r=" : "&_r=") + Math.random()
		return return_val ;
	},
	// 返回数组中是否包含指定元素
	contains: function(array, obj) {
	    for (var i = 0; i < array.length; i++) {
	        if (array[i] == obj) {
	            return true;
	        }
	    }
	    return false;
	},
	// 获取输入框中当前光标的位置
	getPositionForInput: function (ctrl){
		var caretPos = 0;
		ctrl = ctrl[0];
		if(document.selection){
			ctrl.focus();
			var sel = document.selection.createRange();
			sel.moveStart('character', -ctrl.value.length);
			caretPos = sel.text.length;		
		}else if(ctrl.selectionStart || ctrl.selectionStart == '0'){
			caretPos = ctrl.selectionStart;
		}
		return caretPos;
	},
	// 更新页面内容
	page_update: function(id, link, clear){
		var _this = this;
		// $(id).hide();
		$(id).load(link, function(){
			var _t = $(id);
			var old_link = _t.data("link");
			if(old_link != link){
				_t.data("old-link", old_link);
			}
			_t.data("link", link);
			// 重新执行一次性时间，页面渲染
			o_fn.once();
			// 清理页面载入事件
			if(clear){
				Messenger().hideAll();
			}
			//_t.fadeIn('fast');

			//_this.init_duoshuo();
		});
	},
	/**
	 * 初始化多说评论
	 */
	init_duoshuo: function(){
		window.duoshuoQuery = {short_name:"orionis"};
	    this.load_js('http://static.duoshuo.com/embed.js');
	},
	// 全选
	select_all: function(id){
		 var _checked = $("#" + id).data("_check");
		 if(_checked){
		 	$("#" + id).data("_check", false);
		    $("#" + id + " td input._select:checkbox").attr('checked', false);
		 }else{
		 	$("#" + id).data("_check", true);
		    $("#" + id + " td input._select:checkbox").attr('checked', true);
		 }
		 return false;
	},
	// 对表格执行Ajax批量动作
	table_ajax_action: function(url, table_id, act, info, _data){
		var _this = this;
		var ids = $("#" + table_id + " td input._select:checked");
		var id_list = '';
		ids.each(function(){
			id_list += $(this).val() + ",";
		});
		if(id_list == ''){
			alert('您没有选择项!~')
			return false;
		}
		f.confirm(info, function(res){
			if(res){
				$.get(_this.parseUrl(url), {act:act, ids:id_list, data:_data},
					function(data){
				  		_this.tip(data.info, data.status == '1' ? 'success': 'error');
				  		if(data.status == 1){
				    		_this.page_update("#main-area", $("#main-area").data("link"));
				  		}
					},'json');
			}
		});
	},
	// Ajax表单提交
	ajaxSubmit: function(_this, before, after){
		var __this__ = this;

		// 表单Ajax提交
		var beforeSubmit;
		var success;

		// 默认beforeSubmit事件
		if(typeof before != "function"){
			before = _this.attr("before");
			if(_.isEmpty(before)){
				beforeSubmit = function(){
					UM.sync();
				};
			}else{
				beforeSubmit = function(){
					return eval(before + "()");
				};
			}
		}else{
			beforeSubmit = before;
		}
		
		// 默认success事件
		if(typeof after != 'function'){
			after = _this.attr("success");
			if(_.isEmpty(after)){
				success = function(data){
					if(data.status == '1'){
						Messenger().hideAll();
						__this__.tip(data.info, "success");
						__this__.page_update("#main-area", $("#main-area").data("link"));
					}else{
						__this__.tip(data.info, "error");
					}
				};
			}else{
				success = function(data){
					return eval(after + "(data)");
				};
			}
		}else{
			success = after;
		}
		
		
		_this.ajaxSubmit({
			beforeSubmit: beforeSubmit,
			success: success,
			timeout: 3000,
			dataType: "json",
			error: function(){	
				__this__.tip("表单处理超时!", "error");
			}
		});
		return false;
	}
};