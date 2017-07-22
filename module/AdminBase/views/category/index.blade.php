@extends('layout.layout')
@section('title', '分类管理')
@section('cssImport')
    <style>
        .toggle{
            cursor: pointer;
        }
        .display{
            color: transparent;
            filter:alpha(opacity=0);
        }

        .display::selection {
            background: #ff5722;
            color: #ff5722;
        }
    </style>
@endsection
@section('content')
    <blockquote class="layui-elem-quote layui-form">
        <div class="layui-inline">
            分类域
        </div>
        <div class="layui-inline">
            <select id="category_root" lay-filter="chooseRoot" data-id="{{$roots[0]->id}}">
                @foreach($roots as $root)
                    <option value="{{$root->id}}">{{$root->name}}</option>
                @endforeach
            </select>
        </div>
        @canshow(category@postAdd)
        <div class="layui-inline">
            <a class="layui-btn add_btn" data-id=""  style="background-color:#5FB878" data-url="{{route('category@add',['id'=>''])}}">添加分类</a>
        </div>
        @endcanshow
        <div class="clear-float"></div>
    </blockquote>

    <div class="layui-form table_list">
        <table id="table" class="layui-table" data-url="{{route('category@list')}}">
            <colgroup>
                <col width="5%"/>
                <col width="60%"/>
                <col width="10%"/>
                <col width="25%"/>
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

        @{{# var cannotMoveTag = {}; }}
        @{{# cannotMoveTag['up'] = {}; }}
        @{{# cannotMoveTag['down'] = {}; }}
        @{{# layui.each(d, function(index, item){ }}
        @{{# if(cannotMoveTag.up[item.depth] === undefined){ }}
        @{{# cannotMoveTag.up[item.depth] = index; }}
        @{{# } }}
        @{{# cannotMoveTag.down[item.depth] = index; }}
        @{{# }) }}


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

                @canshow(category@moveUp)
                <a class="layui-btn layui-btn-mini layui-btn-warm move_btn @{{ index == cannotMoveTag.up[item.depth] || (index > 0 && item.depth-1 == d[index-1].depth) ? 'layui-btn-disabled' : '' }}" data-id="@{{ item.id }}" data-url="{{route('category@moveUp',['id'=>''])}}"><i class="coca-icon coca-icon-moveup"></i></a>
                @endcanshow

                @canshow(category@moveDown)
                <a class="layui-btn layui-btn-mini layui-btn-warm move_btn @{{ index == cannotMoveTag.down[item.depth] || (index < d.length - 1 && item.depth-1 == d[index+1].depth)? 'layui-btn-disabled' : '' }}" data-id="@{{ item.id }}" data-url="{{route('category@moveDown',['id'=>''])}}"><i class="coca-icon coca-icon-movedown"></i></a>
                @endcanshow
                @canshow(category@postAdd)
                <a class="layui-btn layui-btn-mini add_btn" data-id="@{{ item.id }}" data-url="{{route('category@add',['id'=>''])}}"><i class="layui-icon">&#xe654;</i> 添加子分类</a>
                @endcanshow
                @canshow(category@postEdit)
                <a class="layui-btn layui-btn-mini edit_btn" data-id="@{{ item.id }}" data-url="{{route('category@edit',['id'=>''])}}"><i class="iconfont icon-edit"></i> 编辑</a>
                @endcanshow
                @canshow(category@del)
                <a class="layui-btn layui-btn-danger layui-btn-mini del_btn" data-id="@{{ item.id }}" data-url="{{route('category@del',['id'=>''])}}"><i class="layui-icon">&#xe640;</i> 删除</a>
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