@extends('layout.layout')
@section('title', '管理')

@section('content')
    <blockquote class="layui-elem-quote layui-form">
        <div class="layui-inline">
            模块开发文档: <a class="layui-btn layui-btn-mini" target="_blank" href="#">暂无</a>
        </div>
    </blockquote>
    <form class="layui-form table_list">
        <table id="table" class="layui-table" data-url="{{route('module@list')}}">
            <colgroup>
                <col width="15%"/>
                <col width="15%"/>
                <col width="10%"/>
                <col width="50%"/>
                <col width="220"/>
            </colgroup>
            <thead>
            <tr>
                <th>模块ID</th>
                <th>模块名称</th>
                <th>作者</th>
                <th>模块描述</th>
                <th>状态</th>
            </tr>
            </thead>
            <tbody class="table_content"></tbody>
        </table>
    </form>

    <script id="table-tpl" type="text/html">
        @{{#  layui.each(d, function(index, item){ }}
        <tr>
            <td>@{{ item.id }}</td>
            <td>@{{ item.name }}</td>
            <td>@{{ item.author }}</td>
            <td>@{{ item.description }}</td>
            <td>
                @canshow(module@changeStatus)
                    @{{# if(item.auto){ }}
                        显示
                    @{{# }else if(item.status == 1){ }}
                        <input type="checkbox"
                               data-id="@{{ item.id }}"
                               lay-skin="switch"
                               value="1"
                               lay-text="显示|隐藏" checked
                               lay-filter="switchShow"
                               data-url="{{route('module@changeStatus')}}"
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
                                data-url="{{route('module@changeStatus')}}"
                        >
                    @{{# } }}
                @else
                    @{{# if(item.status == 1 || item.auto){ }}
                    显示
                    @{{# }else{ }}
                    隐藏
                    @{{# } }}
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
    @jsimport(module/index)
@endsection