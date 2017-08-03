@extends('layout.layout')
@section('title', '修改密码')
@section('cssImport')
    @cssimport(main)
@endsection
@section('content')
    <div class="panel_box row">

        <div class="panel col">
            <a href="javascript:;" data-url="{{route('user@index')}}">
                <div class="panel_icon" style="background-color:#FF5722;">
                    <i class="iconfont icon-dongtaifensishu" data-icon="iconfont icon-dongtaifensishu"></i>
                </div>
                <div class="panel_word userAll">
                    <span></span>
                    <cite>新增代理数</cite>
                </div>
            </a>
        </div>
        <div class="panel col">
            <a href="javascript:;" data-url="{{route('user@index')}}">
                <div class="panel_icon" style="background-color:#009688;">
                    <i class="layui-icon" data-icon="&#xe613;">&#xe613;</i>
                </div>
                <div class="panel_word userAll">
                    <span></span>
                    <cite>代理总数</cite>
                </div>
            </a>
        </div>

        <div class="panel col">
            <a href="javascript:;" data-url="{{route('order@admin@index')}}">
                <div class="panel_icon">
                    <i class="coca-icon coca-icon-dingdan2" data-icon="coca-icon coca-icon-dingdan2"></i>
                </div>
                <div class="panel_word newMessage">
                    <span></span>
                    <cite>待处理订单</cite>
                </div>
            </a>
        </div>

        <div class="panel col">
            <a href="javascript:;" data-url="{{route('order@admin@index')}}">
                <div class="panel_icon" style="background-color:#5FB878;">
                    <i class="coca-icon coca-icon-dingdan1" data-icon="coca-icon coca-icon-dingdan1"></i>
                </div>
                <div class="panel_word imgAll">
                    <span></span>
                    <cite>订单总数</cite>
                </div>
            </a>
        </div>


        <div class="panel col">
            <a href="javascript:;" data-url="page/news/newsList.html">
                <div class="panel_icon" style="background-color:#F7B824;">
                    <i class="iconfont icon-wenben" data-icon="icon-wenben"></i>
                </div>
                <div class="panel_word waitNews">
                    <span>0</span>
                    <cite>待审核文章</cite>
                </div>
            </a>
        </div>
        <div class="panel col max_panel">
            <a href="javascript:;" data-url="page/news/newsList.html">
                <div class="panel_icon" style="background-color:#2F4056;">
                    <i class="iconfont icon-text" data-icon="icon-text"></i>
                </div>
                <div class="panel_word allNews">
                    <span>0</span>
                    <em>文章总数</em>
                    <cite>文章列表</cite>
                </div>
            </a>
        </div>
    </div>

    <blockquote class="layui-elem-quote explain">
        <p>欢迎使用本系统，本系统由 空帆船工作室 开发！</p>
    </blockquote>
@endsection

@section('jsImport')
    @jsimport(main)
@endsection