<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>@yield('title') - 后台管理平台</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="{{ asset('/layui/css/layui.css') }}" media="all" />
    <link rel="stylesheet" href="//at.alicdn.com/t/font_tnyc012u2rlwstt9.css" media="all" />
    <link rel="stylesheet" href="{{config('icon.css')}}" media="all" />
    <link rel="stylesheet" href="{{ asset('/module/AdminBase/css/main.css') }}" media="all" />
@section("cssImport")
    @show
</head>
<body class="childrenBody">
    @section('content')
        这是主要内容。
    @show
<script type="text/javascript" src="{{ asset('/layui/layui.js') }}"></script>
<script>
    layui.config({
    }).use(['jquery'],function(){
        var $  = layui.jquery;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
</script>
    <script type="text/javascript" src="{{config('icon.js')}}"></script>
@section("jsImport")
@show
</body>
</html>