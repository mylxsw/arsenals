/**
 * 初始化一些必选的功能
 * @author 管宜尧<mylxsw@126.com>
 */
var resourcePath = $("body").attr('data-resource');
var app = {
	slider_play: function(){
		fn.load_css(resourcePath + 'SliderPlay/sliderPlay-2.0.min.css');
		fn.load_js([resourcePath + 'SliderPlay/jquery-SliderPlay-2.0.min.js'], function(){
			$('#sliderPlay').sliderPlay({
				speed: 300, 		
				timeout: 4000,		 
				moveType: 'randomMove',  
				mouseEvent: 'click', 
				isShowTitle: true,	
				isShowBtn:  true  
			});
		});
	}
		
};

$(function(){
	var loadEvent = function(jsEventLoadAttr){
		var jsDataLoad = jsEventLoadAttr.split(",");
		for(var x = 0; x < jsDataLoad.length; x ++){
			if(fn.is_empty(jsDataLoad[x])){
				continue;
			}
			if(/\./.test(jsDataLoad[x])){
				eval(jsDataLoad[x] + "()");
				continue;
			}
			app[jsDataLoad[x]]();
		}
	};
	try{
		var jsEventLoadAttr = $("#js-control").attr("data-load").replace(/-/g, "_").replace(/\s/g, "");
		loadEvent(jsEventLoadAttr);
	}catch(e){}
	
});
