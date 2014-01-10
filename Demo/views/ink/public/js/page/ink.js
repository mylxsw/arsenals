define('page/ink', ['jquery'], function($){
	return {
		breadcrumbs: function(){
			$(".breadcrumbs .active a").live('click', function(e){
				e.preventDefault();
			});
		}
	};
});