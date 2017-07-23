var $;
layui.config({
}).use(['form','layer','jquery','upload','laydate'],function(){
    var form = layui.form(),
        layer = parent.layer === undefined ? layui.layer : parent.layer,
        $ = layui.jquery,
        laydate = layui.laydate;

    layui.upload({
        url : window.uploadUrl+'?name=userFace',
        success: function(res){
            if(res.code == 0){
                $('#userFace').attr('src',window.baseUrl+res.data);
                $('[name=avatar]').val(res.data);
            }else{
                layer.alert(data.msg, {icon: 2});
            }
        }
    });

    form.on("submit(submit)",function(data){
        var index = top.layer.msg('数据提交中，请稍候',{icon: 16,time:false,shade:0.8});
        var url = $(this).data('url');
        $.ajax({
            url:url,
            type:'post',
            dataType:'json',
            data:data.field,
            success:function (data) {
                top.layer.close(index);
                if(data.code == 0){
                    top.layer.msg("操作成功！");
                    layer.closeAll("iframe");
                }else{
                    layer.alert(data.msg, {icon: 2});
                }
            }
        });
        return false;
    })

});