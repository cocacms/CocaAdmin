layui.config({
}).use(['form','layer','jquery'],function(){
	var form = layui.form(),
		layer = parent.layer === undefined ? layui.layer : parent.layer,
		$ = layui.jquery,
		tips = layer.tips
	;


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content')
        }
    });

	//video背景
	$(window).resize(function(){
		if($(".video-player").width() > $(window).width()){
			$(".video-player").css({"height":$(window).height(),"width":"auto","left":-($(".video-player").width()-$(window).width())/2});
		}else{
			$(".video-player").css({"width":$(window).width(),"height":"auto","left":-($(".video-player").width()-$(window).width())/2});
		}
	}).resize();
	
	//登录按钮事件
	form.on("submit(login)",function(data){

		$.ajax({
			url:'../admin/login',
			type:'post',
			dataType:'json',
			data:data.field,
			success:function (data) {
				if(data.code == 0){
                    location.href = '../admin'
				}else{
                    tips(data.msg, '.login_btn', {
                        tips: [1, 'red'],
                        time: 1500
                    });
                    $('[name=code]').val('');
                    $('#captcha').attr('src',$('#captcha').data('url')+Math.random());
                    if(data.msg == '账户密码有误！'){
                        $('[name=password]').val('');
                    }
				}
            }
		});
		return false;
	});
	$('#captcha').click(function () {
		$(this).attr('src',$(this).data('url')+Math.random());
    })
});
