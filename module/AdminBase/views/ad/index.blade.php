@extends('layout.layout')
@section('title', '管理')

@section('content')
    <blockquote class="layui-elem-quote layui-form">
        @canshow(ad@add)
        <div class="layui-inline">
            <a class="layui-btn add_btn" style="background-color:#5FB878" data-url="{{route('ad@add')}}">添加广告</a>
        </div>
        @endcanshow
        @canshow(ad@del)
        <div class="layui-inline">
            <a class="layui-btn layui-btn-danger batch_del" data-url="{{route('promo@del')}}">批量删除</a>
        </div>
        @endcanshow
        <div class="clear-float"></div>
    </blockquote>
    <form class="layui-form table_list">
        <table id="table" class="layui-table" data-url="{{route('ad@list')}}">
            <colgroup>
                <col width="50"/>
                <col width="10%"/>
                <col width="15%"/>
                <col width="10%"/>
                <col width="50%"/>
                <col width="220"/>
                <col width="15%"/>
            </colgroup>
            <thead>
            <tr>
                <th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose" id="allChoose"></th>
                <th style="text-align:left;">ID</th>
                <th>名称</th>
                <th>标识</th>
                <th>代码</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody class="table_content"></tbody>
        </table>
    </form>
    <div id="page"></div>

    <script id="table-tpl" type="text/html">
        @{{#  layui.each(d, function(index, item){ }}
        <tr>
            <td><input type="checkbox" name="checked" lay-skin="primary" lay-filter="choose"></td>
            <td align="left">@{{ item.id }}</td>
            <td>@{{ item.name }}</td>
            <td>@{{ item.tag }}</td>
            <td>@{{=item.script }}</td>
            <td>
                @canshow(ad@changeShow)
                    @{{# if(item.show == 1){ }}
                        <input type="checkbox"
                               data-id="@{{ item.id }}"
                               lay-skin="switch"
                               value="1"
                               lay-text="显示|隐藏" checked
                               lay-filter="switchShow"
                               data-url="{{route('ad@changeShow')}}"
                               checked
                        >
                    @{{# }else{ }}
                        <input
                                type="checkbox"
                                data-id="@{{ item.id }}"
                                lay-skin="switch"
                                value="1"
                                lay-text="显示|隐藏"
                                lay-filter="switchShow"
                                data-url="{{route('ad@changeShow')}}"
                        >
                    @{{# } }}
                @else
                    @{{# if(item.show == 1){ }}
                    显示
                    @{{# }else{ }}
                    隐藏
                    @{{# } }}
                @endcanshow
            </td>

            <td>
                @canshow(promo@edit)
                <a class="layui-btn layui-btn-mini edit_btn" data-id="@{{ item.id }}" data-url="{{route('ad@edit',['id'=>''])}}"><i class="iconfont icon-edit"></i> 编辑</a>
                @endcanshow
                @canshow(promo@del)
                <a class="layui-btn layui-btn-danger layui-btn-mini del_btn" data-id="@{{ item.id }}" data-url="{{route('ad@del')}}"><i class="layui-icon">&#xe640;</i> 删除</a>
                @endcanshow
            </td>
        </tr>

        @{{#  }); }}

        @{{#  if(d.length === 0){ }}
        <tr><td colspan="7">暂无数据</td></tr>
        @{{#  } }}
    </script>

@endsection

@section('jsImport')
    @jsimport(ad/index)
@endsection