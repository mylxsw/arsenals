/**
 * 常用函数库
 * @author 管宜尧
 * 2013-10-12
 */
window.f = {
	/**
	 * 循环索引
	 */
	_cycle_index: 0,
	// 数据表格
	dataTable: function(selector, url){
		$(selector).dataTable({
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": url,
            "oLanguage":{
            	"sProcessing": "处理中...",
            	"sLengthMenu": "显示 _MENU_ 条记录",
            	"sZeroRecords": "没有记录.",
            	"sInfo": "显示第 _START_ 到 _END_ 条记录，总共 _TOTAL_ 条记录",
            	"sInfoEmpty": "没有信息",
            	"sInfoFiltered": "(从 _MAX_ 条记录中过滤)",
            	"sInfoPostFix": "",
            	"sSearch": "搜索",
            	"sUrl": "",
            	"oPaginate": {
            		"sFirst":    "首页",
            		"sPrevious": "上一页",
            		"sNext":     "下一页",
            		"sLast":     "末页"
            	}
            }
        });
	},
	// Alert消息
	alert: function(message, callback){
		callback = callback || function(){};
		$.Dialog({
			shadow: true,
			overlay: true,
			icon:'<span class="icon-rocket"></span>',
			title: "系统消息",
			width: 500,
			padding: 10,
			content: message,
			sysButtons: {
				btnClose: true
			},
			sysBtnCloseClick: function(e){
				callback();
			}
		});
	},
	// 提示消息
	// type : info , success, error
	tip: function(message, type, delay){
		if(typeof type == "undefined"){
			type = "info";
		}
		delay = delay || 3000;
		var style = false;
		switch (type) {
		case 'info':
			style = {background: '#1ba1e2', color: 'white'};
			break;
		case 'error':
			style = {background: 'red', color: 'white'};
			break;
		case 'success':
			style = {background: 'green', color: 'white'};
			break;
		case 'alert':
			style = false;
			break;
		}
		$.Notify({content: message, style: style, timeout: delay});
	},
	// 执行异步请求
	async: function(url, params, callback, method){
		method = method || "get";
		params = params || {};
		callback = callback || function(data){
			f.tip(data.info);
		};
		
		if(method == 'get'){
			$.get(url, params, callback, "json");
		}else{
			$.post(url, params, callback, "json");
		}
	},
	// 确认消息
	confirm: function(message, callback){
		$.Dialog({
			overlay: true,
			shadow: true,
			icon: '<span class="icon-rocket"></span>',
			title: '确认',
			content: '',
			padding: 20,
			width: 400,
			onShow: function(_dialog){
			    var content = '<div>' + message + '</div><div class="o-button-panel">\
			    			<button class="primary btn-confirm-ok">确定</button>\
			    			<button onclick="$.Dialog.close()">取消</button>\
			    			</div>';
			    
			    $.Dialog.title("确认操作");
			    $.Dialog.content(content);
			    $(".btn-confirm-ok").unbind('click').bind("click", function(){
			    	callback();
			    	$.Dialog.close();
			    });
			}
		});
	},
	/**
	 * 打开对话框
	 * @param url
	 * @param title
	 * @param params
	 * @param callback 页面展示后的回调函数
	 */
	dialog: function(url, title, params, callback){
		params = params || {};
		callback = callback || function(){};
		$.get(url, params, function(data){
			$.Dialog({
				shadow: true,
				overlay: true,
				icon:'<span class="icon-rocket"></span>',
				title: title,
				draggable: true,
				padding: 10,
				content: data,
				sysButtons: {
					btnClose: true
				},
				onShow: function(_dialog){
					callback();
				}
			});
		});
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
	 * 循环数组中的值
	 */
	cycle: function(array){
		if(this._cycle_index >= array.length){
			this._cycle_index = 0;
		}
		return array[this._cycle_index ++];
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
		var deal_file = "admin.php/";
		if(url == ''){
			return basePath;
		}
		if(url.indexOf("http://") == 0 
				|| url.indexOf("https://") == 0 
				|| url.indexOf("ftp://") == 0 ){
			return url;
		}
		var params = url.split("??", 2);
		url = params[0];
		var return_val = "";
		if(url.indexOf("/") == 0){
			return_val= basePath + deal_file + url.substring(1)
					+ (params.length == 2 ? ("?" + params[1] ) :  "");
		}else{
			return_val = basePath + deal_file + url + (params.length == 2 ? ("?" + params[1] ) : "" );
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
		link = _this.parseUrl(link);
		// $(id).hide();
		_this.tip('页面加载中...', 'info', 1500);
		$(id).fadeOut('fast');
		$(id).load(link, function(){
			var _t = $(id);
			var old_link = _t.data("link");
			if(old_link != link){
				_t.data("old-link", old_link);
			}
			_t.data("link", link);
			$(this).fadeIn();
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
	submit: function(selector){
		return this.ajaxSubmit($(selector));
	},
	/**
	 * Ajax表单提交
	 * @param _this 要提交的表单对象
	 * @param before 提交前置事件
	 * @param after 提交后处理事件
	 * @returns {Boolean}
	 */
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
					if(typeof(UM) != 'undefined'){
						UM.sync();
					}
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
						//Messenger().hideAll();
						__this__.tip(data.info, "success");
						__this__.page_update("#main-area", $("#main-area").data("link"));
						$.Dialog.close();
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