<?php Demo\views\ink\header();?>
<div>
	<div id='sliderPlay' style='visibility: hidden'>
		<a href='http://www.webrhai.com/' target="_blank"><img src='http://ww3.sinaimg.cn/large/adde8400gw1ebn1vgnos8j20k00ag0us.jpg' alt='这是标题一' height='376px' width='940px'/></a>
		<a href='http://www.webrhai.com/' target="_blank"><img src='http://ww4.sinaimg.cn/large/adde8400gw1ebn1vktdigj20k00ag0vt.jpg' alt='这是标题二' height='376px' width='940px'/></a>
		<a href='http://www.webrhai.com/' target="_blank"><img src='http://ww3.sinaimg.cn/large/adde8400gw1ebn1vokqzqj20k00ag3zo.jpg' alt='这是标题三' height='376px' width='940px'/></a>
		<a href='http://www.webrhai.com/' target="_blank"><img src='http://ww4.sinaimg.cn/large/adde8400gw1ebn1vqhh67j20k00aggo0.jpg' alt='这是标题四' height='376px' width='940px'/></a>
		<a href='http://www.webrhai.com/' target="_blank"><img src='http://ww2.sinaimg.cn/large/adde8400gw1ebn1vuhpzcj20k00agq4v.jpg' alt='这是标题五' height='376px' width='940px'/></a>
	</div>

	<div>
		<div class="new-product push-left">
			<div class="np-title">新品活动</div>
			<div class="np-body">
				<?php $_new_good = \Demo\views\ink\new_blog(4);?>
				<img src="<?php echo $_new_good[0]['blog_img'];?>" />
				<p><?php echo $_new_good[0]['blog_title'];?></p>
			</div>
		</div>
		<div class="new-activy pull-left">
			<div class="na-title">最新活动</div>
			<?php $_new_activys = \Demo\views\ink\new_blog(2, 6);?>
			<div class="na-body">
			<?php foreach ($_new_activys as $_ak=>$_av):?>
				<div class="na-block">
					<img src="<?php echo $_av['blog_img'];?>" title="<?php echo $_av['blog_title'];?>"/>
					<div class="nab-title"><a href="<?php echo $_av['id'];?>" title="<?php echo $_av['blog_title'];?>"><?php echo $_av['blog_title'];?></a></div>
					<div class="ink-clear"></div>
				</div>
			<?php endforeach;?>
			</div>
		</div>
	</div>
</div>
<script>
require(['jquery', 'page/home'], function($, home){
	home.slider_play();
});
</script>
<?php Demo\views\ink\footer();?>