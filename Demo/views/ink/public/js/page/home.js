define("page/home", ['jquery', 'common', 'underscore', 'backbone'], function($, fn, _, Backbone){
	return {
		slider_play: function(){
			fn.load_css(global.public_resources_path + 'SliderPlay/sliderPlay-2.0.min.css');
			fn.load_js([global.public_resources_path + 'SliderPlay/jquery-SliderPlay-2.0.min.js'], function(){
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
});