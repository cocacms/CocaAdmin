layui.config({
}).use(['form','layer','upload','jquery'],function(){
	var form = layui.form(),
		layer = parent.layer === undefined ? layui.layer : parent.layer,
		$ = layui.jquery;

    layui.upload({
        url : "../../upload?name=webLogoFile",
        success: function(res){
            if(res.code == 1){
                $('#webLogoImg').attr('src','../../'+res.data);
                $('[name=weblogo]').val(res.data);
            }
        }
    });

 	form.on("submit(systemParameter)",function(data){
        var index = layer.msg('提交中，请稍候',{icon: 16,time:false,shade:0.8});
        $.ajax({
            url:'../../admin/system/submitConfig',
            type:'post',
            dataType:'json',
            data:data.field,
            success:function (data) {
                layer.close(index);
                if(data.code == 0){
                    layer.alert(data.msg, {icon: 2});
                }else{
                    layer.msg("系统基本参数修改成功！");
                }
            }
        });
        return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
 	})


});
