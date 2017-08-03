@extends('layout.layout')
@section('title', '修改密码')
@section('cssImport')
    @cssimport(main)
@endsection
@section('content')
    <div class="panel_box row">
        <div class="panel col">
            <a href="javascript:;" data-url="page/message/message.html">
                <div class="panel_icon">
                    <i class="layui-icon" data-icon="&#xe63a;">&#xe63a;</i>
                </div>
                <div class="panel_word newMessage">
                    <span></span>
                    <cite>新消息</cite>
                </div>
            </a>
        </div>
        <div class="panel col">
            <a href="javascript:;" data-url="page/user/allUsers.html">
                <div class="panel_icon" style="background-color:#FF5722;">
                    <i class="iconfont icon-dongtaifensishu" data-icon="icon-dongtaifensishu"></i>
                </div>
                <div class="panel_word userAll">
                    <span></span>
                    <cite>新增人数</cite>
                </div>
            </a>
        </div>
        <div class="panel col">
            <a href="javascript:;" data-url="page/user/allUsers.html">
                <div class="panel_icon" style="background-color:#009688;">
                    <i class="layui-icon" data-icon="&#xe613;">&#xe613;</i>
                </div>
                <div class="panel_word userAll">
                    <span></span>
                    <cite>用户总数</cite>
                </div>
            </a>
        </div>
        <div class="panel col">
            <a href="javascript:;" data-url="page/img/images.html">
                <div class="panel_icon" style="background-color:#5FB878;">
                    <i class="layui-icon" data-icon="&#xe64a;">&#xe64a;</i>
                </div>
                <div class="panel_word imgAll">
                    <span></span>
                    <cite>图片总数</cite>
                </div>
            </a>
        </div>
        <div class="panel col">
            <a href="javascript:;" data-url="page/news/newsList.html">
                <div class="panel_icon" style="background-color:#F7B824;">
                    <i class="iconfont icon-wenben" data-icon="icon-wenben"></i>
                </div>
                <div class="panel_word waitNews">
                    <span></span>
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
                    <span></span>
                    <em>文章总数</em>
                    <cite>文章列表</cite>
                </div>
            </a>
        </div>
    </div>
    <blockquote class="layui-elem-quote explain">
        <p>本系统采用 <a href="https://laravel.com/" target="_blank" class="layui-btn layui-btn-mini layui-btn-danger">Laravel5.4</a>框架 与 <a href="https://github.com/BrotherMa/layuiCMS" target="_blank" class="layui-btn layui-btn-mini layui-btn-danger">LayuiCMS</a>前端模板开发！</p>
        <p>开发文档地址：
            <a class="layui-btn layui-btn-mini" target="_blank" href="#">暂无</a>
            <a class="layui-btn layui-btn-mini layui-btn-danger" target="_blank" href="https://github.com/rojer95/CocaAdmin.git">GitHub</a>　交流QQ群：<a target="_blank" href="//shang.qq.com/wpa/qunwpa?idkey=eb29d64a4ccddd38150619ccda8476699a467c9e3c74b109c58641001f3e5a43"><img border="0" src="//pub.idqqimg.com/wpa/images/group.png" alt="Coca Admin" title="Coca Admin"></a>
        </p>
    </blockquote>
    <div class="row">
        <div class="sysNotice col">
            <blockquote class="layui-elem-quote title">更新日志</blockquote>
            <div class="layui-elem-quote layui-quote-nm">

            </div>
        </div>
        <div class="sysNotice col">
            <blockquote class="layui-elem-quote title">系统基本参数</blockquote>
            <table class="layui-table">
                <colgroup>
                    <col width="150">
                    <col>
                </colgroup>
                <tbody>
                <tr>
                    <td>当前版本</td>
                    <td class="version"></td>
                </tr>
                <tr>
                    <td>开发作者</td>
                    <td class="author"></td>
                </tr>
                <tr>
                    <td>网站首页</td>
                    <td class="homePage"></td>
                </tr>
                <tr>
                    <td>服务器环境</td>
                    <td class="server"></td>
                </tr>
                <tr>
                    <td>数据库版本</td>
                    <td class="dataBase"></td>
                </tr>
                <tr>
                    <td>最大上传限制</td>
                    <td class="maxUpload"></td>
                </tr>
                <tr>
                    <td>当前用户权限</td>
                    <td class="userRights"></td>
                </tr>
                </tbody>
            </table>
            <blockquote class="layui-elem-quote title">最新文章<i class="iconfont icon-new1"></i></blockquote>
            <table class="layui-table" lay-skin="line">
                <colgroup>
                    <col>
                    <col width="110">
                </colgroup>
                <tbody class="hot_news"></tbody>
            </table>
        </div>
    </div>
@endsection

@section('jsImport')
    @jsimport(main)
@endsection