@extends('layout.layout')
@section('title', '分类管理')
@section('cssImport')
@endsection
@section('content')
    <blockquote class="layui-elem-quote layui-form" lay-filter='chooseRoot' data-id="">
        @canshow(category@postAdd)
        <div class="layui-inline">
            <a class="layui-btn add_btn" data-id=""  style="background-color:#5FB878" data-url="{{route('category@rootAdd')}}">添加分类域</a>
        </div>
        @endcanshow
    </blockquote>

    <div class="layui-form table_list">
        <table id="table" class="layui-table" data-url="{{route('category@rootList')}}">
            <colgroup>
                <col width="5%"/>
                <col width="60%"/>
                <col width="20%"/>
                <col width="15%"/>
            </colgroup>
            <thead>
            <tr>
                <th style="text-align:left;">ID</th>
                <th style="text-align:left;">分类名称</th>
                <th>标识</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody class="table_content"></tbody>
        </table>
    </div>

    <script id="table-tpl" type="text/html">

        @{{#  layui.each(d, function(index, item){ }}
        <tr data-lft="@{{ item.lft }}" data-rgt="@{{ item.rgt }}" data-depth="@{{ item.depth }}">
            <td align="left">@{{ item.id }}</td>
            <td align="left">@{{ item.name }}</td>
            @{{# if(item.tag != null){ }}
            <td>@{{ item.tag }}</td>
            @{{# }else{ }}
            <td>-</td>
            @{{# } }}
            <td>
                @canshow(category@postEdit)
                <a class="layui-btn layui-btn-mini edit_btn" data-id="@{{ item.id }}" data-url="{{route('category@rootEdit',['id'=>''])}}"><i class="iconfont icon-edit"></i> 编辑</a>
                @endcanshow
                @canshow(category@del)
                <a class="layui-btn layui-btn-danger layui-btn-mini del_btn" data-id="@{{ item.id }}" data-url="{{route('category@rootDel',['id'=>''])}}"><i class="layui-icon">&#xe640;</i> 删除</a>
                @endcanshow
            </td>
        </tr>


        @{{#  }); }}

        @{{#  if(d.length === 0){ }}
        <tr><td colspan="4">暂无数据</td></tr>
        @{{#  } }}
    </script>

@endsection

@section('jsImport')
    @jsimport(category/index)
@endsection