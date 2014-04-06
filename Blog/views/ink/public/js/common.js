/**
 * 通用的一些函数
 * @author Code.404
 * 2013-9-19
 */
var fn = {
	// 提示消息
	alert: function(message){
		alert(message);
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
	 * @param callback
	 */
	load_js: function(js, callback){
        
        var that = this;
		if(this.is_empty(callback)){
			var ds = document.createElement('script');
		    ds.type = 'text/javascript';
		    ds.async = true;
		    ds.src = js;
		    ds.charset = 'UTF-8';
		    (document.getElementsByTagName('head')[0]
		    	|| document.getElementsByTagName('body')[0]).appendChild(ds);
		}else{
			// 异步获取js内容
			// 递归方式加载所有的js完成后执行回调函数
			var urlArray = $.isArray(js) ? js : [js];
			var current = 0;
			var exec = function(url){
				// 直接使用ajax方法可以带缓存
				$.ajax({
					url: url,
					cache: true,
					dataType:"script",
					success:function(data){
						//执行加载
						try{
							//eval(data);
							current ++;
							if(current < urlArray.length){
								// 递归调用，加载所有的js文件
								exec(urlArray[current]);
							}else{
								// 加载完所有的js文件后执行回调函数
								// 保证了在js文件都加载完成之后才执行回调函数
								callback();
							}
						}catch(exception){
							alert("加载文件失败");
							throw(exception);
						}
					}
				});
			};
			exec(urlArray[current]);
		}
	},
	/**
	 * 动态加载css文件
	 */
	load_css: function(css){
		var container = document.getElementsByTagName("head")[0];
        var addStyle = document.createElement("link");
        addStyle.rel = "stylesheet";
        addStyle.type = "text/css";
        addStyle.media = "screen";
        addStyle.href = css;
        container.appendChild(addStyle);
	},
	/**
	 * 判断变量是否为空
	 */
	is_empty:function(str){// 判断变量是否为空
		return str == undefined || str == "" || str == null;
	}
};
