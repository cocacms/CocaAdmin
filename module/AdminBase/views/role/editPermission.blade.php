@extends('layout.layout')
@section('title', '编辑角色权限')
@section('cssImport')
    <style type="text/css">

    </style>
@endsection

@section('content')
    <form class="layui-form" style="width:100%;">
        @foreach($routeGroup as $name =>$routes)
        <div class="layui-form-item">

            <fieldset class="layui-elem-field">
                <legend>{{$name}}</legend>
                <div class="layui-field-box">
                    @foreach($routes as $route)
                        <input type="checkbox" name="permission[{{$route['uriWithMethod']}}]" title="{{$route['name']}}" {{$route['checked'] ? 'checked' : ''}}>
                    @endforeach
                </div>
            </fieldset>


        </div>
        @endforeach
        <div class="layui-form-item">
            <div style="text-align: center">
                <button class="layui-btn" lay-submit="" lay-filter="editRolePermission" data-url="{{route('role@submitPermission',['id'=>$id])}}">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>

@endsection

@section('jsImport')
    @jsimport(role/editRolePermission)
@endsection