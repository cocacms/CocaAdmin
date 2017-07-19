@extends('layout.layout')
@section('title', '角色管理')

@section('content')
    <blockquote class="layui-elem-quote news_search">
        @canshow(role@edit)
        <div class="layui-inline">
            <a class="layui-btn linksAdd_btn" style="background-color:#5FB878">添加角色</a>
        </div>
        @endcanshow
        @canshow(role@del)
        <div class="layui-inline">
            <a class="layui-btn layui-btn-danger batchDel">批量删除</a>
        </div>
        @endcanshow
        <div class="clear-float"></div>
    </blockquote>
    <div class="layui-form links_list">
        <table class="layui-table">
            <colgroup>
                <col width="50"/>
                <col width="80%"/>
                <col width="20%">
            </colgroup>
            <thead>
            <tr>
                <th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose" id="allChoose"></th>
                <th style="text-align:left;">角色名称</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody class="links_content"></tbody>
        </table>
    </div>

    <script id="table-tpl" type="text/html">
        @{{#  layui.each(d, function(index, item){ }}
        <li>
            <td><input type="checkbox" name="checked" lay-skin="primary" lay-filter="choose"></td>
            <td align="left">@{{ item.name }}</td>
            <td>
                @canshow(role@edit)
                <a class="layui-btn layui-btn-mini links_edit" data-id="@{{ item.id }}"><i class="iconfont icon-edit"></i> 编辑</a>
                @endcanshow
                <a class="layui-btn layui-btn-mini links_edit_permission" data-id="@{{ item.id }}"><i class="coca-icon coca-icon-quanxian2"></i> 设置权限</a>
                @canshow(role@del)
                <a class="layui-btn layui-btn-danger layui-btn-mini links_del" data-id="@{{ item.id }}"><i class="layui-icon">&#xe640;</i> 删除</a>
                @endcanshow
            </td>
        </li>

        <tr>

        </tr>
        @{{#  }); }}

        @{{#  if(d.length === 0){ }}
        <tr><td colspan="3">暂无数据</td></tr>
        @{{#  } }}
    </script>

@endsection

@section('jsImport')
    @jsimport(role)
@endsection