<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>@yield('title') - 后台管理平台</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
    window.uploadUrl = '{{route('webUpload')}}';
    window.baseUrl = '{{asset('')}}';
    layui.config({
    }).use(['jquery','form'],function(){
        var $  = layui.jquery;
        var jQuery = layui.jquery;
        var form = layui.form();
        form.verify({
            username: function(value, item) {
                if (!new RegExp("^[a-zA-Z0-9_\u4e00-\u9fa5\\s·]+$").test(value)) {
                    return '用户名不能有特殊字符';
                }
            },
            length: function(value, item) {
                var length = $(item).attr('v-length');
                if(length == undefined){
                    length = '0,999';
                }
                var minmax = length.split(',');

                if (value.length < minmax[0] || value.length > minmax[1]) {
                    return '输入长度必须'+minmax[0]+'到'+minmax[1]+'位';
                }
            },
            price: function(value, item){
                var reg = /(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/;
                if (!reg.test(value)) {
                    return '请输入正确的金额数';
                }
            }
        });

        $.ajaxSetup({
            headers: {
                'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
</script>
    <script type="text/javascript" src="{{config('icon.js')}}"></script>
    @section("jsImport")
    @show
</body>
</html>