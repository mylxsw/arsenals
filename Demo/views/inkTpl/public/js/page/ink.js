define('page/ink', ['jquery', 'common'], function($, fn){
	return {
		breadcrumbs: function(){
			$(".breadcrumbs .active a").live('click', function(e){
				e.preventDefault();
			});
		},
		duoshuo: function(){
			window.duoshuoQuery = {short_name:"orionis"};
		    fn.load_js('http://static.duoshuo.com/embed.js');
		}
	};
});