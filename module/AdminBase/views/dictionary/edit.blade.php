@extends('layout.layout')
@section('title', '添加字典')
@section('cssImport')
    <style type="text/css">
        .layui-form-item .layui-inline{ width:33.333%; float:left; margin-right:0; }
        @media(max-width:1240px){
            .layui-form-item .layui-inline{ width:100%; float:none; }
        }
        .kvinput{
            display: inline-block;
            width: 40%
        }
    </style>
@endsection

@section('content')
    <form class="layui-form" style="width: 80%;">
        <div class="layui-form-item">
            <label class="layui-form-label">字典标识</label>
            <div class="layui-input-block">
                <input type="text" value="{{$dictionary->tag}}" name="tag" class="layui-input" placeholder="请输入字典标识，选填">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">字典名</label>
            <div class="layui-input-block">
                <input type="text" name="name" value="{{$dictionary->name}}" class="layui-input" lay-verify="required" placeholder="请输入字典名">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">字典描述</label>
            <div class="layui-input-block">
                <textarea id="description" name="description" style="display: none;">{{$dictionary->description}}</textarea>
            </div>
        </div>

        <div class="layui-form-item" id="kvs">
            <label class="layui-form-label">选项键值对</label>
            @foreach($dictionary->content as $content)
                @php
                    $rand = microtime().mt_rand();
                @endphp
                <div class="layui-input-block">
                    <input type="text" name="content[{{$rand}}][k]" value="{{$content['k']}}" class="layui-input kvinput" lay-verify="required" placeholder="请输入键">
                    <input type="text" name="content[{{$rand}}][v]" value="{{$content['v']}}" class="layui-input kvinput" lay-verify="required" placeholder="请输入值">
                    <div style="display: inline-block;" >
                        <button style="margin-left: 10px;" class="layui-btn addkv">+</button>
                        <button class="layui-btn delkv">-</button>
                    </div>
                </div>

            @endforeach



        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="submit" data-url="{{route('dictionary@postEdit',['id'=>$dictionary->id])}}">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>

    <script type="text/html" id="kv-temp">
        <div class="layui-input-block">
            <input type="text" name="k" value="" class="layui-input kvinput" lay-verify="required" placeholder="请输入键">
            <input type="text" name="v" value="" class="layui-input kvinput" lay-verify="required" placeholder="请输入值">
            <div style="display: inline-block;">
                <button style="margin-left: 10px;" class="layui-btn addkv">+</button>
                <button class="layui-btn delkv">-</button>
            </div>
        </div>
    </script>

@endsection

@section('jsImport')
    @jsimport(dictionary/edit)
@endsection