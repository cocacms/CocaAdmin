<!doctype html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <!-- Set render engine for 360 browser -->
    <meta name="renderer" content="webkit">

    <!-- No Baidu Siteapp-->
    <meta http-equiv="Cache-Control" content="no-siteapp"/>

    <!-- <link rel="icon" type="image/png" href="assets/i/favicon.png"> -->

    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">
    <!-- <link rel="icon" sizes="192x192" href="assets/i/app-icon72x72@2x.png"> -->

    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Amaze UI"/>
    <!-- <link rel="apple-touch-icon-precomposed" href="assets/i/app-icon72x72@2x.png"> -->

    <!-- Tile icon for Win8 (144x144 + tile color) -->
    <!-- <meta name="msapplication-TileImage" content="assets/i/app-icon72x72@2x.png"> -->
    <meta name="msapplication-TileColor" content="#0e90d2">

    <link rel="stylesheet" href="{{asset('web/css/amazeui.min.css')}}" media="all" />
    <link rel="stylesheet" href="{{asset('web/css/app.css')}}" media="all" />

    @section("cssImport")
    @show
</head>
<body>
@inject('category_helper','category_helper')
<div class="header">
    <div class="content">
        <div class="logo">
            <a href="{{route('pager@home')}}">
                <img src="{{asset(system_config('weblogo'))}}" alt="">
                <span class="am-show-sm" style="position: relative;top: -9px;">{{system_config('webname')}}</span>
            </a>
        </div>
        <ul class="nav am-hide-sm">
            @foreach(pagers($category_helper->getIds('header')) as $pager)
                <li><a href="{{route('pager@show',['tag' => $pager->tag])}}">{{$pager->name}}</a></li>
            @endforeach
        </ul>
        <ul class="login am-hide-sm">
            @if(is_null($_user))
                <li>
                    <a href="{{route('web@login')}}">登录账户</a>
                </li>
            @else
                <li>
                    {{$_user->nickname or $_user->username}}
                </li>
                <li>
                    <a href="{{route('web@logout')}}"> 退出</a>
                </li>
            @endif


            <li>
                <a href="shopcart.html"><span class="am-icon-shopping-cart"></span></a>
            </li>
        </ul>
        <div class="login">
            <span class="am-icon-bars am-show-sm am-icon-sm" data-am-offcanvas="{target: '#header-bars', effect: 'push'}"></span>
        </div>
    </div>
</div>


<!-- 侧边栏内容 -->
<div id="header-bars" class="am-offcanvas">
    <div class="am-offcanvas-bar am-offcanvas-bar-flip">
        <div class="am-offcanvas-content">
            <ul>
                <li>
                    <a href="{{route('web@login')}}">登录账户</a>
                </li>
                @foreach(pagers($category_helper->getIds('header')) as $pager)
                    <li><a href="{{route('pager@show',['tag' => $pager->tag])}}">{{$pager->name}}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>


<div data-am-widget="navbar" class="am-navbar am-cf am-navbar-default am-show-sm" id="">
    <ul class="am-navbar-nav am-cf am-avg-sm-4">
        <li >
            <a href="index.html" class="">
                <span class="am-icon-home"></span>
                <span class="am-navbar-label">首页</span>
            </a>
        </li>
        <li >
            <a href="shopcart.html" class="">
                <span class="am-icon-shopping-cart"></span>
                <span class="am-navbar-label">购物车</span>
            </a>
        </li>
        <li >
            <a href="my.html" class="">
                <span class="am-icon-user"></span>
                <span class="am-navbar-label">我的</span>
            </a>
        </li>
    </ul>
</div>

@section('content')
    这是主要内容。
@show


<div class="footer am-hide-sm">
    {{system_config('powerby')}}  | {{system_config('record')}}
</div>



<!--[if (gte IE 9)|!(IE)]><!-->
<script type="text/javascript" src="{{asset('web/js/jquery-1.9.1.min.js')}}"></script>

<!--<![endif]-->
<!--[if lte IE 8 ]>
<script type="text/javascript" src="{{asset('web/js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('web/js/modernizr.js')}}"></script>
<script type="text/javascript" src="{{asset('web/js/amazeui.ie8polyfill.min.js')}}"></script>
<![endif]-->
<script type="text/javascript" src="{{asset('web/js/amazeui.min.js')}}"></script>
<script type="text/javascript" src="{{asset('web/js/app.js')}}"></script>
@section("jsImport")
@show
<script type="application/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
</body>
</html>