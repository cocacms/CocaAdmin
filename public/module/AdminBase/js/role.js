layui.config({
}).use(['form','layer','jquery','laytpl'],function(){
    var form = layui.form(),
        layer = parent.layer === undefined ? layui.layer : parent.layer,
        laytpl = layui.laytpl,
        $ = layui.jquery;

    //加载页面数据
    var loadData = function () {
        $.ajax({
            url : "../admin/role/list",
            type : "get",
            dataType : "json",
            success : function(data){
                if(data.code == 1){
                    //执行加载数据的方法
                    linksList(data.data);
                }

            }
        });

    };
    loadData();
    //添加角色
    $(".linksAdd_btn").click(function(){
        var index = layui.layer.open({
            title : "添加角色",
            type : 2,
            content : "../admin/role/edit",
            success : function(layero, index){
                setTimeout(function(){
                    layui.layer.tips('点击此处返回友链列表', '.layui-layer-setwin .layui-layer-close', {
                        tips: 3
                    });
                },500)
            },
            end:function () {
                loadData();
            }
        });
        //改变窗口大小时，重置弹窗的高度，防止超出可视区域（如F12调出debug的操作）
        $(window).resize(function(){
            layui.layer.full(index);
        });
        layui.layer.full(index);
    });

    //批量删除
    $(".batchDel").click(function(){
        var $checkbox = $('.links_list tbody input[type="checkbox"][name="checked"]');
        var $checked = $('.links_list tbody input[type="checkbox"][name="checked"]:checked');
        if($checkbox.is(":checked")){
            layer.confirm('确定删除选中的信息？',{icon:3, title:'提示信息'},function(index){
                var index = layer.msg('删除中，请稍候',{icon: 16,time:false,shade:0.8});
                //删除数据
                var ids = [];
                for(var j=0;j<$checked.length;j++){
                    ids.push($checked.eq(j).parents("tr").find(".links_del").data("id"));
                }
                $.ajax({
                    url : '',
                    type: 'DELETE',
                    data:{ids:ids},
                    success:function (data) {
                        if(data.code == 1){
                            loadData();
                            layer.msg("删除成功");
                        }else{
                            layer.alert(data.msg, {icon: 2});
                        }
                    }
                });
            })
        }else{
            layer.msg("请选择需要删除的项目");
        }
    });

    //全选
    form.on('checkbox(allChoose)', function(data){
        var child = $(data.elem).parents('table').find('tbody input[type="checkbox"]:not([name="show"])');
        child.each(function(index, item){
            item.checked = data.elem.checked;
        });
        form.render('checkbox');
    });

    //通过判断文章是否全部选中来确定全选按钮是否选中
    form.on("checkbox(choose)",function(data){
        var child = $(data.elem).parents('table').find('tbody input[type="checkbox"]:not([name="show"])');
        var childChecked = $(data.elem).parents('table').find('tbody input[type="checkbox"]:not([name="show"]):checked')
        data.elem.checked;
        if(childChecked.length == child.length){
            $(data.elem).parents('table').find('thead input#allChoose').get(0).checked = true;
        }else{
            $(data.elem).parents('table').find('thead input#allChoose').get(0).checked = false;
        }
        form.render('checkbox');
    });

    //操作
    $("body").on("click",".links_edit",function(){  //编辑
        // layer.alert('您点击了友情链接编辑按钮，由于是纯静态页面，所以暂时不存在编辑内容，后期会添加，敬请谅解。。。',{icon:6, title:'友链编辑'});
        var id = $(this).data('id');
        var index = layui.layer.open({
            title : "编辑角色",
            type : 2,
            content : "../admin/role/edit/"+id,
            success : function(layero, index){
                setTimeout(function(){
                    layui.layer.tips('点击此处返回友链列表', '.layui-layer-setwin .layui-layer-close', {
                        tips: 3
                    });
                },500)
            },
            end:function () {
                loadData();
            }
        });
        //改变窗口大小时，重置弹窗的高度，防止超出可视区域（如F12调出debug的操作）
        $(window).resize(function(){
            layui.layer.full(index);
        });
        layui.layer.full(index);
    });

    //操作
    $("body").on("click",".links_edit_permission",function(){  //编辑
        var id = $(this).data('id');
        var index = layui.layer.open({
            title : "编辑角色权限",
            type : 2,
            area: ['800px', '500px'],
            offset: '100px',
            content : "../admin/role/editPermission/"+id
        });
        //改变窗口大小时，重置弹窗的高度，防止超出可视区域（如F12调出debug的操作）
        // $(window).resize(function(){
        //     layui.layer.full(index);
        // });
        // layui.layer.full(index);
    });

    $("body").on("click",".links_del",function(){  //删除
        var _this = $(this);
        layer.confirm('确定删除此信息？',{icon:3, title:'提示信息'},function(index){
            //_this.parents("tr").remove();
            var id = _this.data("id");
            $.ajax({
                url : '',
                type: 'DELETE',
                data:{ids:[id]},
                success:function (data) {
                    if(data.code == 1){
                        loadData();
                        layer.msg("删除成功！");
                    }else{
                        layer.alert(data.msg, {icon: 2});
                    }
                }
            });
            layer.close(index);
        });
    });

    function linksList(that){
        var getTpl = $('#table-tpl').html();
        laytpl(getTpl).render(that, function(html){
            $('.links_content').html(html);
            form.render();
        });
    }
});
