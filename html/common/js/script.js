// jquery.matchHeight-min.js
document.write('<script type="text/javascript" src="/common/js/jquery.matchHeight-min.js"></script>');
var ua = navigator.userAgent;
var os, ver ='', browser = '', ie = '', sp = 0;
var bpx = 768;

$(window).on('load',function(){
	urlhash = location.hash;
	if( urlhash != "" ){
		$('#head').addClass('fixed');
	}
});
$(function(){
	//OS、端末判定
	if (ua.match(/Win(dows )?NT 10\.0/)) {
		os = 'win win10';
	} else if (ua.match(/Win(dows )?NT 6\.3/)) {
		os = "win win8-1";
	} else if (ua.match(/Win(dows )?NT 6\.2/)) {
		os = "win win8";
	} else if (ua.match(/Win(dows )?NT 6\.1/)) {
		os = 'win win7';
	} else if (ua.match(/Win(dows )?NT 6\.0/)) {
		os = 'win winVista';
	} else if (ua.match(/Win(dows )?(NT 5\.1|XP)/)) {
		os = 'win winXp';
	} else if (ua.match(/Mac|PPC/) && ua.search(/iPhone|iPod|iPad/) == -1) {
		os = 'mac';
	} else {
		sp = 1;
		if (ua.search(/iPhone/) != -1) {
			os = 'iphone';
		} else if(ua.search(/iPad/) != -1){
			os = 'ipad';
		} else if(ua.search(/Android/) != -1){
			os = 'android';
			if( ua.search(/Android 2/) != -1 ) { ver = 'ver_2'; }
			if( ua.search(/Android 3/) != -1 ) { ver = 'ver_3'; }
			if( ua.search(/Android 4/) != -1 ) { ver = 'ver_4'; }
		}
	}

	//ブラウザ判定
	if(ua.match(/msie/i) || ua.match(/Trident/)){
		ie = "IE";
		if(ua.match(/msie 10/i)) {
			browser = "IE10";
		} else if(ua.match(/msie 9/i)) {
			browser = "IE9";
		} else if(ua.match(/msie 8/i)){
			browser = "IE8";
		} else if(ua.match(/msie 7/i)){
			browser = "IE7";
		} else if(ua.match(/msie 6/i)){
			browser = "IE6";
		}
	} else if(ua.match(/firefox/i)){
		browser = "firefox";
	} else if(ua.match(/opera/i)){
		browser = "opera";
	} else if(ua.match(/netscape/i)){
		browser = "netscape";
	} else if(ua.match(/safari/i)){
		if(ua.match(/chrome/i)){ browser = "chrome"; } else { browser = "safari"; }
	}
	$('body').addClass(os+' '+browser+' '+ver);
	if(ie){ $('body').addClass(ie); }
	if( sp == 1 ){ $('body').addClass('sp'); } else{ $('body').addClass('pc'); }

	// 電話番号
	$('.tel[data-tel]').on('click',function(){
		if( sp == 1 ){
			telNum = $(this).attr('data-tel');
			if(typeof gtag == 'function'){
				gtag('event', 'action', { 'event_category' : 'tel', 'event_label' : telNum });
			} else if(typeof ga == 'function'){
				ga('send', 'event', 'コンバージョン', '電話', telNum);
			}
			window.location.href = "tel:"+telNum;
		}
	});
	$('a[href^="tel:"]').on('click',function(){
		if( sp == 1 ){
			telNum = $(this).attr('href');
			telNum = telNum.replace('tel:','');
			if(typeof gtag == 'function'){
				gtag('event', 'action', { 'event_category' : 'tel', 'event_label' : telNum });
			} else if(typeof ga == 'function'){
				ga('send', 'event', 'コンバージョン', '電話', telNum);
			}
			return true;
		} else{
			return false;
		}
	});
	$('a[href$=".pdf"]').on('click',function(){
		ahref = $(this).attr('href');
		if(typeof gtag == 'function'){
			gtag('event', 'action', { 'event_category' : 'pdf', 'event_label' : ahref });
		} else if(typeof ga == 'function'){
			ga('send', 'event', 'リンク', 'PDF', ahref);
		}
		return true;
	});
	$('a.ga_link').on('click',function(){
		ahref = $(this).attr('href');
		if(typeof gtag == 'function'){
			gtag('event', 'action', { 'event_category' : 'link', 'event_label' : ahref });
		} else if(typeof ga == 'function'){
			ga('send', 'event', 'リンク', 'link', ahref);
		}
		return true;
	});

	// 印刷処理
	var beforePrint = function(){ $('head meta[name="viewport"]').attr('content','width=1200px'); };
	var afterPrint = function(){ $('head meta[name="viewport"]').attr('content','width=device-width, initial-scale=1'); };
	if(window.matchMedia){
		var mediaQueryList = window.matchMedia('print');
		mediaQueryList.addListener(function(mql){
			if(mql.matches){
				beforePrint();
				$('body').addClass('print');
			} else {
				afterPrint();
				$('body').removeClass('print');
			}
		});
	}
	window.onbeforeprint = beforePrint;
	window.onafterprint = afterPrint;

	// pagetop & scroll
	$('#pagetop, #foot_link').hide();
	$(window).scroll(function(){
		if($(this).scrollTop() > 100){ $('#pagetop, #foot_link').fadeIn(); } else { $('#pagetop, #foot_link').fadeOut(); }
		if($(this).scrollTop() > 100){ $('#head').addClass('fixed'); } else{ $('#head').removeClass('fixed'); }
	});
	$('#pagetop').on('click',function(){
		$('body,html').animate({ scrollTop:0 }, 500);
		return false;
	});

	// main menu
	$('#btn_open a').on('click',function(){
		$('#base').toggleClass('open');
		if( $('#menu_cover').get(0) ){
			$(this).html('<i class="fa fa-bars"></i>');
			$('#menu_cover').remove();
		} else{
			$(this).html('<i class="fa fa-times"></i>');
			$('#base').append('<div id="menu_cover"></div>');
		}
		return false;
	});
	$('#head_navi > ul > li').on({
		'mouseenter' : function(){
			$('#head_navi > ul > li').removeClass('on');
			$(this).addClass('on');
		},
		'mouseleave' : function(){
			$(this).delay(5000).queue(function(){
				if( $(this).hasClass('on') ){
					$(this).removeClass('on').dequeue();
				}
			});
		}
	});

	// table
	$('.entry table').each(function(){
		if( $(this).hasClass('tbl_form') == false ){
			$(this).wrap('<div class="sp_table_wrap"></div>');
		}
	});

	// form
	$('#send_button').on('click', function(){
		$(this).attr('formaction', './send.php');
	});

});

// 高さ調整
$(window).on('load resize',function(){
	$('.height-1_all').matchHeight();
	$('.height-2_all').matchHeight();
	$('.height-1r_all').matchHeight({ byRow:false });
	$('.height-2r_all').matchHeight({ byRow:false });
	if($(window).innerWidth() >= 576 ){
		$('.height-1').matchHeight();
		$('.height-2').matchHeight();
		$('.height-1r').matchHeight({ byRow:false });
		$('.height-2r').matchHeight({ byRow:false });
	}
	$('.img_back').each(function(){
		if( $(this).children('img') ){
			src = $(this).children('img').attr('src');
			$(this).css({'background-image':'url('+src+')'});
		}
	});
	$('.img_sq').each(function(){
		if( $(this).children('img') ){
			src = $(this).children('img').attr('src');
			srcw = $(this).innerWidth();
			$(this).css({'background-image':'url('+src+')',
						'height':srcw});
		}
	});
	$('.img_rect').each(function(){
		if( $(this).children('img') ){
			src = $(this).children('img').attr('src');
			srcw = $(this).innerWidth();
			$(this).css({'background-image':'url('+src+')',
						'height':(srcw / 1.638)});
		}
	});
});

// parallax
var plList = [], plTops = [], plDef = 0;
var ParallaxTimer = false;
$(window).on('load resize',function(){
	if( sp == '1' ){ return true; }
	if( typeof $('.parallax').get(0) == 'undefined' ){ return true; }

	// reset
	plList = [];
	plTops = [];
	plDef = parseInt($(window).innerHeight());

	$('.parallax').each(function(){
		plt = $(this).offset().top;
		if( $(this).attr('data-parallax-top') ){
			plt = plt + parseInt($(this).attr('data-parallax-top'));
		}
		if( plt < plDef ){
			$(this).addClass('parallax_on');
		} else{
			plList.push($(this));
			plTops.push(parseInt(plt));
		}
	});
});
$(window).on('scroll',function(){
	clearTimeout(ParallaxTimer);
	ParallaxTimer = setTimeout(function(){
		if( plTops[0] ){ ParallaxScroll(); }
	}, 10);
});

function ParallaxScroll(){
	if( Math.min.apply(null,plTops) < $(window).scrollTop() + plDef){
		elm = plList[0];
		$(elm).addClass('parallax_on');

		plList.splice(0,1);
		plTops.splice(0,1);
		if( plTops[0] ){ ParallaxScroll(); }
	}
}
