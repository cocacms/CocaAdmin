$(function(){
	adjust(false)
});

$(window).resize(function(){
	adjust(true)
});

function adjust(is){
	if($('body').height() < $(window).height() || is){
		var h = 0;
		if ($(window).width() > 640) {
			h = $(window).height() - $('.header').height() - $('.footer').height();
		}else{

			h = $(window).height() - $('.header').height() - $('.am-navbar').height() - 6;
		}
		$('.main-content').css('min-height',h+'px');
	}
}