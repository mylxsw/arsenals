/**
 * 欢迎使用 SliderPlay 幻灯片『焦点图』插件
 *
 * jQuery SliderPlay plugin
 * ========================================〓说明〓========================================================
 * jQuery幻灯片插件，基本能满足你在网页上使用幻灯片(焦点图)效果。兼容IE6/IE7/IE8/IE9,FireFox,Chrome,Opera等主流浏览器。
 * 使用极其方便、简单，外观样式可以自定义,具体定义样式方法和设置其他参数请参见demo文件
 * ========================================================================================================
 * @name jquery.SliderPlay.js
 * @version 2.0
 * @author Mr.Rong
 * @date 2013-12-10
 * @Email:506713930@qq.com
 * @website: http://www.webrhai.com
 * 欲索取最新版本SliderPlay或是报告Bug，请发送Email至 506713930@qq.com
 *
 * 请尊重他人的劳动作品! 如蒙转载请注明出处 
 **/

;(function(window, $) { 
	$.fn.sliderPlay = function(options) {
		options = $.extend({
				speed: 700, 		//动画效果持续时间
				timeout: 3000,		//幻灯间隔时间
				moveType: 'opacity',  // randomMove: 随机运动，moveTo: 幻灯切换运动 ，opacity: 淡入淡出
				direction: 'left',  //left , top  在moveType 为moveTo的时候,此参数生效
				mouseEvent: 'click', //事件类型，默认是 click ,mouseover
				isShowTitle: true,	//是否开始标题,开启则采用img标签alt的文字
				isShowBtn:  true    //是否显示按钮
		}, options);

		var oSliderPlayBox = this;
		var aSliderPlayImg = oSliderPlayBox.find('img');
		var aSliderPlayItem = oSliderPlayBox.children();
		var size = aSliderPlayImg.length;
		var iSpeed = options.speed;
		var iTimeout = options.timeout;
		var sMoveType = options.moveType;
		var sDirection = options.direction;
		var sMouseEvent = options.mouseEvent;
		var bIsShowTitle = options.isShowTitle;
		var bIsShowBtn = options.isShowBtn;

		var iImgWidth = aSliderPlayImg.width();
		var iImgHeight = aSliderPlayImg.height();
		var iCurIndex = 0;
		var iPrevIndex = 0;
		var iBtnIndex = 0;
		var oAutoTimer = null;
		var oTimer = null;
		var flag = false;
		var autoPlay = function() {};
		var move = function() {};



		//检测传入的参数是否有误.
		if(sMouseEvent != 'mouseover' && sMouseEvent != 'click') {
			sMouseEvent = 'click';
		}
		if(sDirection != 'left' && sDirection != 'top') {
			sMouseEvent = 'left';
		}
		if(sMoveType != 'randomMove' && sMoveType != 'moveTo' && sMoveType != 'opacity') {
			sMoveType = 'moveTo';
		}

		
		//设置默认样式
		!function setDefaultStyle() {
			oSliderPlayBox.addClass('sliderPlay');
			oSliderPlayBox.css({width: iImgWidth, height: iImgHeight , visibility: 'visible'});
		}();


		//如果显示按钮就生成按钮
		if(bIsShowBtn == true) {
			var sBtnHtml = '<div class="sliderPlay-btn"><span class="current">1</span>';
			for(var i = 2; i <= size; i++) {
				sBtnHtml += '<span>'+i+'</span>';
			};
			sBtnHtml += '</div>';

			this.append(sBtnHtml);

			var aSliderPlayBtn = this.find('.sliderPlay-btn').find('span');
		}

		//如果显示title 就生成title,默认显示的title文字为第一张图片的alt;
		if(bIsShowTitle) {
			this.append('<div class="sliderPlay-title">'+aSliderPlayImg.attr('alt')+'</div>');
			var oSliderPlayTitle = this.find('.sliderPlay-title');
		}

		//执行运动函数
		switch(sMoveType) {
			case 'moveTo' :  setMoveTo();  break;
			case 'opacity' : setOptity(); break;
			case 'randomMove' : setRandomMove(); break;
		}

		//添加事件
		function addEvent(move, autoPlay) {  
			if(bIsShowBtn) {
				if(sMouseEvent == 'click') {
					aSliderPlayBtn.on('click', function(e) {
						e.preventDefault();
						oAutoTimer && clearInterval(oAutoTimer);
						iBtnIndex = iCurIndex = $(this).index();
						move()
					})
				} else {
					aSliderPlayBtn.mouseenter(function() {
					    oAutoTimer && clearInterval(oAutoTimer);
						iBtnIndex = iCurIndex = $(this).index();
						oTimer = setTimeout(move, 200)
					}).mouseleave(function(){
						clearTimeout(oTimer)
					})
				}
			}

			oSliderPlayBox.hover(function() {
				   oAutoTimer && clearInterval(oAutoTimer)
				}, function() {
				  oAutoTimer= setInterval(autoPlay, iTimeout)
			})

		};

		//设置按钮的class和标题文字
		function setAttr(index) {
			oSliderPlayTitle &&　oSliderPlayTitle.html( aSliderPlayImg.eq(index).attr('alt') );
			aSliderPlayBtn && aSliderPlayBtn.removeClass('current').eq(index).addClass('current');
		};

		//设置幻灯切换运动
		function setMoveTo() {
			var style = '';

			if(sDirection == 'left') {
				style = 'width:' + (size+1) * iImgWidth +'px';
			} else {
				style = 'height:' + (size+1) * iImgHeight + 'px';
			}
			oSliderPlayBox.css('overflow', 'hidden');
			aSliderPlayItem.wrapAll('<div class="sliderPlayMain" style="position:absolute;left:0;top:0;' + style + '"></div>');
			aSliderPlayImg.css('float', 'left');

			var oSliderPlayMain = oSliderPlayBox.find('.sliderPlayMain');
			var data = {};

			move = function () {
 				if(sDirection == 'left') {
 					data['left'] = -iImgWidth * iCurIndex
 				} else {
 					data['top'] = -iImgHeight * iCurIndex
 				}

				oSliderPlayMain.animate(data, iSpeed, function() {
					if(flag) {
						if(sDirection == 'left') {
							oSliderPlayMain.css('left', 0);
						} else {
							oSliderPlayMain.css('top', 0);
						}
						iCurIndex = 0;
						oSliderPlayMain.children().last().remove();
						flag = false;
					}
				});
				setAttr(iBtnIndex)
			};

			autoPlay = function () {
				iBtnIndex = ++iCurIndex;
				if(iCurIndex == size) {
					aSliderPlayItem.eq(0).clone().appendTo(oSliderPlayMain);
					flag = true;
					iBtnIndex = 0;
				}
				move()
			};

			addEvent(move, autoPlay);
			oAutoTimer = setInterval(autoPlay, iTimeout)
		};

		//设置淡入淡出运动
		function setOptity() {
			aSliderPlayImg.css({position: 'absolute', left: 0, top: 0, display: 'none'}).first().show();

			move = function () {
				setAttr(iCurIndex);

				aSliderPlayImg.stop().fadeOut(iSpeed).eq(iCurIndex).fadeIn(iSpeed);
				iPrevIndex = iCurIndex
			};

			autoPlay = function (){
				iCurIndex++;
				if(iCurIndex == size) {
					iCurIndex = 0;
				}
				move()
			};

			addEvent(move, autoPlay);
			oAutoTimer = setInterval(autoPlay, iTimeout)

		};

		//设置幻灯切换运动
		function setRandomMove() {
			oSliderPlayBox.css('overflow', 'hidden');
			aSliderPlayImg.css({position: 'absolute', left: 0, top: 0, zIndex: 0}).first().css({zIndex: 1});
			var dir = [0, 1, 2, 3];
			
			move = function () {
				var oPrev = aSliderPlayImg.eq(iPrevIndex);
				var o = aSliderPlayImg.eq(iCurIndex);
				var data = {opacity: 0};

				if(dir.length == 0) {
					dir = [0, 1, 2, 3]
				}

				if(dir.length == 4) {
					dir.sort(function() {
						return Math.random() > 0.5 ? 1 : -1
					})
				}
			
				switch(dir.shift()) {
					case 0: data['top'] = -iImgHeight;break; 
					case 1: data['left'] = iImgWidth;break; 
					case 2: data['top'] = iImgHeight;break; 
					default : data['left'] = -iImgWidth
				}

				
				setAttr(iCurIndex);
				oPrev.css('zIndex', 2).animate(data, iSpeed, function(){
						oPrev.css({zIndex: 0, opacity: 1, top: 0, left: 0})
				});
				o.css('zIndex', 1);

				iPrevIndex = iCurIndex;
			};

			autoPlay = function () {
				iCurIndex++;
				if(iCurIndex == size) {
					iCurIndex = 0
				}
				move()
			};
			
			addEvent(move, autoPlay);
			oAutoTimer = setInterval(autoPlay, iTimeout)
		};

		return oSliderPlayBox;
	}
})(window, jQuery);