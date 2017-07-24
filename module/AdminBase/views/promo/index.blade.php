@extends('layout.layout')
@section('title', '宣传滚动栏管理')

@section('content')
    <blockquote class="layui-elem-quote layui-form">
        <div class="layui-inline">
            分类
        </div>
        <div class="layui-inline">
            <select id="category" lay-filter="chooseCategory" data-id="{{array_keys($category->content)[0]}}">
                @foreach($category->content as $k => $v)
                    <option value="{{$k}}">{{$v}}</option>
                @endforeach
            </select>
        </div>

        @canshow(promo@add)
        <div class="layui-inline">
            <a class="layui-btn add_btn" style="background-color:#5FB878" data-url="{{route('promo@add')}}">添加宣传滚动栏</a>
        </div>
        @endcanshow
        @canshow(promo@del)
        <div class="layui-inline">
            <a class="layui-btn layui-btn-danger batch_del" data-url="{{route('promo@del')}}">批量删除</a>
        </div>
        @endcanshow
        <div class="clear-float"></div>
    </blockquote>
    <form class="layui-form table_list">
        <table id="table" class="layui-table" data-url="{{route('promo@list')}}">
            <colgroup>
                <col width="50"/>
                <col width="5%"/>
                <col width="15%"/>
                <col width="10%"/>
                <col width="220"/>
                <col width="220"/>
                <col width="50"/>
                <col width="80"/>
                <col width="15%"/>
            </colgroup>
            <thead>
            <tr>
                <th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose" id="allChoose"></th>
                <th style="text-align:left;">ID</th>
                <th>名称</th>
                <th>标识</th>
                <th>图片</th>
                <th>描述</th>
                <th>状态</th>
                <th>排序
                    @canshow(promo@changeOrder)
                    <button class="layui-btn layui-btn-mini" lay-submit="" lay-filter="submit" data-url="{{route('promo@changeOrder')}}">
                        <i class="coca-icon coca-icon-queren1" ></i>
                    </button>
                    @endcanshow
                </th>
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
            <td><img src="@{{ item.pic }}" height="150px"/></td>
            <td>@{{ item.description }}</td>
            <td>
                @canshow(promo@changeShow)
                    @{{# if(item.show == 1){ }}
                        <input type="checkbox"
                               data-id="@{{ item.id }}"
                               lay-skin="switch"
                               value="1"
                               lay-text="显示|隐藏" checked
                               lay-filter="switchShow"
                               data-url="{{route('promo@changeShow')}}"
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
                                data-url="{{route('promo@changeShow')}}"
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
                @canshow(promo@changeOrder)
                    <input type="number" class="layui-input" name="order[@{{ item.id }}]" data-id="@{{ item.id }}" data-origin="@{{ item.order }}" value="@{{ item.order }}">
                @else
                    @{{ item.order }}
                @endcanshow
            </td>

            <td>
                @canshow(promo@edit)
                <a class="layui-btn layui-btn-mini edit_btn" data-id="@{{ item.id }}" data-url="{{route('promo@edit',['id'=>''])}}"><i class="iconfont icon-edit"></i> 编辑</a>
                @endcanshow
                @canshow(promo@del)
                <a class="layui-btn layui-btn-danger layui-btn-mini del_btn" data-id="@{{ item.id }}" data-url="{{route('promo@del')}}"><i class="layui-icon">&#xe640;</i> 删除</a>
                @endcanshow
            </td>
        </tr>

        @{{#  }); }}

        @{{#  if(d.length === 0){ }}
        <tr><td colspan="9">暂无数据</td></tr>
        @{{#  } }}
    </script>

@endsection

@section('jsImport')
    @jsimport(promo/index)
@endsection