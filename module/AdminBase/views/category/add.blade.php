@extends('layout.layout')
@section('title', '添加分类')
@section('cssImport')
    <style type="text/css">
        .layui-form-item .layui-inline{ width:33.333%; float:left; margin-right:0; }
        @media(max-width:1240px){
            .layui-form-item .layui-inline{ width:100%; float:none; }
        }
    </style>
@endsection

@section('content')
    <form class="layui-form" style="width:90%;">
        <div class="layui-form-item">
            <label class="layui-form-label">分类标识</label>
            <div class="layui-input-block">
                <input type="text" name="tag" value="" class="layui-input" placeholder="请输入分类标识，选填">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">分类名</label>
            <div class="layui-input-block">
                <input type="text" name="name" value="" class="layui-input" lay-verify="required" placeholder="请输入分类名">
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="add" data-url="{{route('category@postAdd',['id'=>$parent_id])}}">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>

@endsection

@section('jsImport')
    @jsimport(category/edit)
@endsection