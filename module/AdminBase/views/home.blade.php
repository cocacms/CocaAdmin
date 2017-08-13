@extends('layout.layout')
@section('title', '修改密码')
@section('cssImport')
    @cssimport(main)
@endsection
@section('content')
    <div class="panel_box row">

        <div class="panel col">
            <a href="javascript:;" data-url="{{route('user@index',['clear'=>1])}}">
                <div class="panel_icon" style="background-color:#FF5722;">
                    <i class="iconfont icon-dongtaifensishu" data-icon="iconfont icon-dongtaifensishu"></i>
                </div>
                <div class="panel_word allNews">
                    <span>{{$new_count_user}}</span>
                    <em>新增代理数</em>
                    <cite>代理管理</cite>
                </div>
            </a>
        </div>
        <div class="panel col">
            <a href="javascript:;" data-url="{{route('user@index')}}">
                <div class="panel_icon" style="background-color:#009688;">
                    <i class="layui-icon" data-icon="&#xe613;">&#xe613;</i>
                </div>
                <div class="panel_word allNews">
                    <span>{{$all_count_user}}</span>
                    <em>代理总数</em>
                    <cite>代理管理</cite>
                </div>
            </a>
        </div>

        <div class="panel col">
            <a href="javascript:;" data-url="{{route('order@admin@index',['filter[status]'=>-1])}}">
                <div class="panel_icon">
                    <i class="layui-icon" data-icon="">&#xe63c;</i>
                </div>
                <div class="panel_word allNews">
                    <span>{{$wait_count_order}}</span>
                    <em>待处理订单</em>
                    <cite>订单列表</cite>
                </div>
            </a>
        </div>

        <div class="panel col">
            <a href="javascript:;" data-url="{{route('order@admin@index')}}">
                <div class="panel_icon" style="background-color:#5FB878;">
                    <i class="coca-icon coca-icon-dingdan1" data-icon="coca-icon coca-icon-dingdan1"></i>
                </div>
                <div class="panel_word allNews">
                    <span>{{$all_count_order}}</span>
                    <em>订单总数</em>
                    <cite>订单列表</cite>
                </div>
            </a>
        </div>


        <div class="panel col">
            <a href="javascript:;">
                <div class="panel_icon" style="background-color:#F7B824;">
                    <i class="coca-icon coca-icon-jinrijiaoyie" data-icon="coca-icon coca-icon-jinrijiaoyie"></i>
                </div>
                <div class="panel_word allNews">
                    <span>{{$today_amount_order}}</span>
                    <em>今日交易额</em>
                    <cite>今日交易额</cite>
                </div>
            </a>
        </div>
        <div class="panel col max_panel">
            <a href="javascript:;">
                <div class="panel_icon" style="background-color:#2F4056;">
                    <i class="coca-icon coca-icon-jiaoyie2" data-icon="coca-icon coca-icon-jiaoyie2"></i>
                </div>
                <div class="panel_word allNews">
                    <span>{{$all_amount_order}}</span>
                    <em>总交易额</em>
                    <cite>总交易额</cite>
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