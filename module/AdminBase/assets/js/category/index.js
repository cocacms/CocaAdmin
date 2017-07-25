layui.config({
}).use(['form','layer','jquery','laytpl','laypage'],function(){
    var form = layui.form(),
        layer = parent.layer === undefined ? layui.layer : parent.layer,
        laytpl = layui.laytpl,
        laypage = layui.laypage,
        $ = layui.jquery;

    var current_root = $('[lay-filter=chooseRoot]').data('id');
    //加载页面数据
    var loadData = function (current_root) {
        var url = $('#table').data('url');
        var root_id =
        $.ajax({
            url : url + '?current_root='+current_root,
            type : "get",
            dataType : "json",
            success : function(data){
                if(data.code == 0){
                    //执行加载数据的方法
                    list(data.data);
                }

            }
        });

    };
    loadData(current_root);

    //添加
    $("body").on("click",".add_btn",function(){
        var url = $(this).data('url');
        var id = $(this).data('id');
        if(id == '') id = current_root;
        var index = layui.layer.open({
            title : "添加分类",
            type : 2,
            content : url + '/' + id,
            area: ['470px', '250px'],
            success : function(layero, index){
            },
            end:function () {
                loadData(current_root);
            }
        });
    });



    //修改root
    form.on("select(chooseRoot)",function (data) {
        current_root = data.value;
        $('[lay-filter=chooseRoot]').data('id',current_root);
        loadData(current_root);
    });

    //编辑操作
    $("body").on("click",".edit_btn",function(){
        var url = $(this).data('url');
        var id = $(this).data('id');
        var index = layui.layer.open({
            title : "编辑分类",
            type : 2,
            content : url +"/"+id,
            area: ['570px', '450px'],
            success : function(layero, index){
            },
            end:function () {
                loadData(current_root);
            }
        });
        // 改变窗口大小时，重置弹窗的高度，防止超出可视区域（如F12调出debug的操作）
        // $(window).resize(function(){
        //     layui.layer.full(index);
        // });
        // layui.layer.full(index);
    });

    //折叠分类列表事件
    $('body').on("click",".toggle",function () {
        if ($(this).hasClass('open')){
            $(this).removeClass('open');
            $(this).addClass('close');
            $(this).html('&#xe623;');
        }else{
            $(this).removeClass('close');
            $(this).addClass('open');
            $(this).html('&#xe625;');
        }
        var tr = $(this).parents('tr');
        var lft = $(tr).data('lft');
        var rgt = $(tr).data('rgt');
        var depth = parseInt($(tr).data('depth'));
        var all = $('.table_content tr');
        for(var i = 0; i < all.length ; i++){
            var itemLft = $(all[i]).data('lft');
            var itemRgt = $(all[i]).data('rgt');
            var itemDepth= parseInt($(all[i]).data('depth'));

            if(lft < itemLft   && itemLft < rgt){
                if ($(this).hasClass('open') && depth + 1 == itemDepth ){
                    $(all[i]).show();
                }else{
                    $(all[i]).hide();
                }
                $(all[i]).find('.toggle').removeClass('open');
                $(all[i]).find('.toggle').addClass('close');
                $(all[i]).find('.toggle').html('&#xe623;');
            }

        }
    });

    //删除操作
    $("body").on("click",".del_btn",function(){
        var url = $(this).data('url');
        var _this = $(this);
        layer.confirm('确定删除此分类及其所有子分类吗？',{icon:3, title:'提示信息'},function(index){
            var id = _this.data("id");
            $.ajax({
                url : url + '/' +id,
                type: 'DELETE',
                success:function (data) {
                    if(data.code == 0){
                        loadData(current_root);
                        layer.msg("删除成功！");
                    }else{
                        layer.alert(data.msg, {icon: 2});
                    }
                }
            });
            layer.close(index);
        });
    });

    //下上移
    $("body").on("click",".move_btn",function(){
        if($(this).hasClass('layui-btn-disabled')) return;
        var index = top.layer.msg('正在移动分类，请稍候',{icon: 16,time:false,shade:0.8});
        var url = $(this).data('url');
        var id = $(this).data("id");
        $.ajax({
            url : url + '/' +id,
            type: 'POST',
            success:function (data) {
                layer.close(index);
                if(data.code == 0){
                    loadData(current_root);
                }else{
                    layer.alert(data.msg, {icon: 2});
                }
            }
        });
    });

    // 展示数据
    function list(that){
        var getTpl = $('#table-tpl').html();
        laytpl(getTpl).render(that, function(html){
            $('.table_content').html(html);
            form.render();
        });
    }
});
