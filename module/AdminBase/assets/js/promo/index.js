layui.config({
}).use(['form','layer','jquery','laytpl','laypage'],function(){
    var form = layui.form(),
        layer = parent.layer === undefined ? layui.layer : parent.layer,
        laytpl = layui.laytpl,
        laypage = layui.laypage,
        $ = layui.jquery;

    var currentPage = 1;
    var currentCategory = $('#category').data('id');

    //加载页面数据
    var loadData = function (page,category) {
        var url = $('#table').data('url');
        $.ajax({
            url : url,
            data:{
                page:page,
                category:category
            },
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
    loadData(currentPage,currentCategory);

    //修改root
    form.on("select(chooseCategory)",function (data) {
        currentCategory = data.value;
        $('[lay-filter=chooseRoot]').data('id',currentCategory);
        currentPage=1;
        loadData(currentPage,currentCategory);
    });


    //添加
    $(".add_btn").click(function(){
        var url = $(this).data('url');
        var index = layui.layer.open({
            title : "添加宣传滚动栏",
            type : 2,
            content : url+'?category='+currentCategory,
            success : function(layero, index){
            },
            end:function () {
                loadData(currentPage,currentCategory);
            }
        });
        $(window).resize(function(){
            layui.layer.full(index);
        });
        layui.layer.full(index);
    });

    //修改排序
    form.on("submit(submit)",function(data){
        var index = top.layer.msg('数据提交中，请稍候',{icon: 16,time:false,shade:0.8});
        var url = $(this).data('url');
        setTimeout(function () {
            var hasError = false;
            for(var item in data.field){
                var v = $('[name=\''+item+'\']').data('origin');
                var id = $('[name=\''+item+'\']').data('id');
                if(data.field[item]!=v){
                    $.ajax({
                        url:url,
                        type:'post',
                        dataType:'json',
                        data:{
                            id:id,
                            order:data.field[item]
                        },
                        async: false,
                        success:function (data) {
                            if(data.code != 0){
                                layer.alert(data.msg, {icon: 2});
                                hasError=true;
                            }
                        }
                    });
                }
            }
            top.layer.close(index);
            if(!hasError) top.layer.msg("操作成功！");
            loadData(currentPage,currentCategory);
        },50);


        return false;
    });

    //批量删除
    $(".batch_del").click(function(){
        var url = $(this).data('url');
        var $checkbox = $('.table_list tbody input[type="checkbox"][name="checked"]');
        var $checked = $('.table_list tbody input[type="checkbox"][name="checked"]:checked');
        if($checkbox.is(":checked")){
            layer.confirm('确定删除选中的信息？',{icon:3, title:'提示信息'},function(index){
                var index = layer.msg('删除中，请稍候',{icon: 16,time:false,shade:0.8});
                //删除数据
                var ids = [];
                for(var j=0;j<$checked.length;j++){
                    ids.push($checked.eq(j).parents("tr").find(".del_btn").data("id"));
                }
                $.ajax({
                    url : url,
                    type: 'DELETE',
                    data:{ids:ids},
                    success:function (data) {
                        if(data.code == 0){
                            loadData(currentPage,currentCategory);
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

    //显示隐藏
    form.on('switch(switchShow)', function(data){
        var is = $(data.elem).is(':checked') ? 1 : 0;
        var id = $(data.elem).data('id');
        var url = $(data.elem).data('url');
        $.ajax({
            url:url,
            type:'post',
            dataType:'json',
            data:{
                id:id,
                show:is
            },
            success:function (data) {
                if(data.code != 0){
                    loadData(currentPage,currentCategory);
                    layer.alert(data.msg, {icon: 2});
                }
            }
        });
    });

    //全选
    form.on('checkbox(allChoose)', function(data){
        var child = $(data.elem).parents('table').find('tbody input[name="checked"]');
        child.each(function(index, item){
            item.checked = data.elem.checked;
        });
        form.render('checkbox');
    });

    //通过判断是否全部选中来确定全选按钮是否选中
    form.on("checkbox(choose)",function(data){
        var child = $(data.elem).parents('table').find('tbody input[name="checked"]');
        var childChecked = $(data.elem).parents('table').find('tbody input[name="checked"]:checked');
        data.elem.checked;
        if(childChecked.length == child.length){
            $(data.elem).parents('table').find('thead input#allChoose').get(0).checked = true;
        }else{
            $(data.elem).parents('table').find('thead input#allChoose').get(0).checked = false;
        }
        form.render('checkbox');
    });

    //编辑操作
    $("body").on("click",".edit_btn",function(){
        var url = $(this).data('url');
        var id = $(this).data('id');
        var index = layui.layer.open({
            title : "编辑宣传滚动栏",
            type : 2,
            content : url +"/"+id,
            success : function(layero, index){
            },
            end:function () {
                loadData(currentPage,currentCategory);
            }
        });
        //改变窗口大小时，重置弹窗的高度，防止超出可视区域（如F12调出debug的操作）
        $(window).resize(function(){
            layui.layer.full(index);
        });
        layui.layer.full(index);
    });

    //删除操作
    $("body").on("click",".del_btn",function(){
        var url = $(this).data('url');
        var _this = $(this);
        layer.confirm('确定删除此信息？',{icon:3, title:'提示信息'},function(index){
            var id = _this.data("id");
            $.ajax({
                url : url,
                type: 'DELETE',
                data:{ids:[id]},
                success:function (data) {
                    if(data.code == 0){
                        loadData(currentPage,currentCategory);
                        layer.msg("删除成功！");
                    }else{
                        layer.alert(data.msg, {icon: 2});
                    }
                }
            });
            layer.close(index);
        });
    });

    //展示数据
    function list(that){
        var getTpl = $('#table-tpl').html();
        laytpl(getTpl).render(that.data, function(html){
            $('.table_content').html(html);
            form.render();
        });
        currentPage = that.current_page;
        laypage({
            cont : "page",
            pages : that.last_page,
            curr : that.current_page,
            jump : function(obj){
                if(that.current_page != obj.curr)
                    loadData(obj.curr,currentCategory)
            }
        })
    }


});
