var $;
layui.config({
}).use(['form','layer','jquery','layedit'],function(){
    var form = layui.form(),
        layer = parent.layer === undefined ? layui.layer : parent.layer,
        $ = layui.jquery,
        layedit = layui.layedit;

    var editor =layedit.build('content',{
        uploadImage:{
            url : window.uploadUrl + "?name=file&temp=layui&module=AdminBase"
        }
    });

    form.on("submit(submit)",function(data){
        data.field.content = layedit.getContent(editor);
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
    });

});