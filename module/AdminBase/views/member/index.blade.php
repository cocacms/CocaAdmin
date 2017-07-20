@extends('layout.layout')
@section('title', '管理员管理')

@section('content')
    <blockquote class="layui-elem-quote">
        @canshow(role@edit)
        <div class="layui-inline">
            <a class="layui-btn add_btn" style="background-color:#5FB878" data-url="{{route('member@edit')}}">添加管理员</a>
        </div>
        @endcanshow
        @canshow(role@del)
        <div class="layui-inline">
            <a class="layui-btn layui-btn-danger batch_del" data-url="{{route('member@del')}}">批量删除</a>
        </div>
        @endcanshow
        <div class="clear-float"></div>
    </blockquote>
    <div class="layui-form table_list">
        <table id="table" class="layui-table" data-url="{{route('member@list')}}">
            <colgroup>
                <col width="50"/>
                <col width="20%"/>
                <col width="10%"/>
                <col width="5%"/>
                <col width="20%"/>
                <col width="20%"/>
                <col width="15%"/>
                <col width="15%"/>
            </colgroup>
            <thead>
            <tr>
                <th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose" id="allChoose"></th>
                <th style="text-align:left;">账户</th>
                <th>头像</th>
                <th>性别</th>
                <th>手机</th>
                <th>邮件</th>
                <th>昵称</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody class="table_content"></tbody>
        </table>
    </div>
    <div id="page"></div>

    <script id="table-tpl" type="text/html">
        @{{#  layui.each(d, function(index, item){ }}
        <li>
            <td><input type="checkbox" name="checked" lay-skin="primary" lay-filter="choose"></td>
            <td align="left">@{{ item.username }}</td>
            <td><img class="layui-circle" width="50px" src="@{{ item.avatar }}"></td>
            <td>@{{ item.sex }}</td>
            <td>@{{ item.tel }}</td>
            <td>@{{ item.mail }}</td>
            <td>@{{ item.nickname }}</td>
            <td>
                @canshow(role@edit)
                <a class="layui-btn layui-btn-mini edit_btn" data-id="@{{ item.id }}" data-url="{{route('member@edit')}}"><i class="iconfont icon-edit"></i> 编辑</a>
                @endcanshow
                @canshow(role@del)
                <a class="layui-btn layui-btn-danger layui-btn-mini del_btn" data-id="@{{ item.id }}" data-url="{{route('member@del')}}"><i class="layui-icon">&#xe640;</i> 删除</a>
                @endcanshow
            </td>
        </li>

        <tr>

        </tr>
        @{{#  }); }}

        @{{#  if(d.length === 0){ }}
        <tr><td colspan="8">暂无数据</td></tr>
        @{{#  } }}
    </script>

@endsection

@section('jsImport')
    @jsimport(member/index)
@endsection