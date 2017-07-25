layui.config({
}).use(['form','layer','jquery','laytpl','laypage'],function(){
    var form = layui.form(),
        layer = parent.layer === undefined ? layui.layer : parent.layer,
        laytpl = layui.laytpl,
        laypage = layui.laypage,
        $ = layui.jquery;

    var currentPage = 1;

    //加载页面数据
    var loadData = function (page) {
        var url = $('#table').data('url');
        $.ajax({
            url : url,
            data:{
                page:page
            },
            type : "get",
            dataType : "json",
            success : function(data){
                if(data.code == 0){
                    //执行加载数据的方法
                    list(data);
                }

            }
        });

    };
    loadData(currentPage);



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
                    loadData(currentPage);
                    layer.alert(data.msg, {icon: 2});
                }else{
                    layer.msg("设置成功 请刷新页面");
                }
            }
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
