var $;
layui.config({
}).use(['form','layer','jquery','layedit'],function(){
    var form = layui.form(),
        layer = parent.layer === undefined ? layui.layer : parent.layer,
        $ = layui.jquery,
        layedit = layui.layedit;

    var editor =layedit.build('description',{
        uploadImage:{
            url : window.uploadUrl + "?name=file&temp=layui&module=AdminBase"
        }
    });
    form.on("submit(submit)",function(data){
        data.field.description = layedit.getContent(editor);
        console.log(data.field);
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

    $("body").on('click','.addkv',function () {
        var _this = $(this).parents('.layui-input-block');
        var temp = $($('#kv-temp').html());
        var rank = parseInt(new Date().getTime() + parseInt(Math.random() * 100000));
        temp.find('[name=k]').attr('name','content['+rank+'][k]');
        temp.find('[name=v]').attr('name','content['+rank+'][v]');
        _this.after(temp);
        return false;
    })

    $("body").on('click','.delkv',function () {
        if($('#kvs').find('.layui-input-block').length <= 1) return false;
        var _this = $(this).parents('.layui-input-block');
        _this.remove();
        return false;
    })

});