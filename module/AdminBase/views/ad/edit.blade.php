@extends('layout.layout')
@section('title', '编辑')
@section('cssImport')
    <style type="text/css">
        .layui-form-item .layui-inline{ width:33.333%; float:left; margin-right:0; }
        @media(max-width:1240px){
            .layui-form-item .layui-inline{ width:100%; float:none; }
        }
    </style>
@endsection

@section('content')
    <form class="layui-form" style="width: 80%;">
        <div class="layui-form-item">
            <label class="layui-form-label">广告标识</label>
            <div class="layui-input-block">
                <input type="text" name="tag" value="{{$ad->tag}}" placeholder="请输入广告标识" lay-verify="required" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">名称</label>
            <div class="layui-input-block">
                <input type="text" name="name" value="{{$ad->name}}" placeholder="请输入名称" lay-verify="required" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">广告代码</label>
            <div class="layui-input-block">
                <textarea rows="20" name="script" placeholder="请输入广告代码" class="layui-textarea">{{$ad->script}}</textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">是否展示</label>
            <div class="layui-input-block">
                <input type="checkbox" name="show" value="1" lay-skin="switch" lay-text="展示|隐藏" {{$ad->show == 1 ? 'checked':''}}>
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="submit" data-url="{{route('ad@postEdit',['id'=>$ad->id])}}">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>

@endsection

@section('jsImport')
    @jsimport(ad/edit)
@endsection