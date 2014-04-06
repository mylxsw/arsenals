var i = {
	breadcrumbs: function(){
		$(".breadcrumbs .active a").live('click', function(e){
			e.preventDefault();
		});
	},
	duoshuo: function(){
		window.duoshuoQuery = {short_name:"orionis"};
	    fn.load_js('http://static.duoshuo.com/embed.js');
	},
    pictureTip: function(){
        $(".picture").mouseover(function(){
        	$(this).find('.img-tip').stop(true, true).fadeIn('fast');
            $(this).addClass("rotate-7");
        }).mouseout(function(){
        	$(this).find('.img-tip').stop(true, true).fadeOut('fast');
        	$(this).removeClass("rotate-7");
        });
    },
    initSearchPanel: function(){
        $(".search-panel input[name='keyword']").focusin(function(){
        	$(".search-panel").css("width", "200px");
        }).focusout(function(){
        	$(".search-panel").css("width", "100px");
        });
        
        $(".search-panel input[name='keyword']").keydown(function(event){
            if(event.keyCode == 13){
                window.open("http://www.baidu.com/baidu?word=site:blog.aicode.cc%20" + $(this).val() + "&ie=utf-8");
            }
        
        });
    }
};
