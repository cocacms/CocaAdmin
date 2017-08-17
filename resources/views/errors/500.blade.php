<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>发生未知错误啦！</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="{{ asset('/layui/css/layui.css') }}" media="all" />
    <style type="text/css">
        .icon {
            width: 57rem;
            height: 14rem;
            vertical-align: -0.15em;
            fill: currentColor;
            overflow: hidden;
            margin-bottom: 20px;
        }
    </style>
</head>
<body class="childrenBody">
<div style="text-align: center; padding:11% 0;color : #656565">
    <svg class="icon" aria-hidden="true">
        <use xlink:href="#coca-icon-wuneirong"></use>
    </svg>
    <p style="font-size: 20px; font-weight: 300;">发生未知错误啦!</p>
    @if(config('app.debug'))
    <p >{{$exception->getMessage()}}</p>
    <p >{{$exception->getFile()}} Line: {{$exception->getLine()}}</p>
        @foreach($exception->getTrace() as $trace)
            <p style="text-align: left;width: 600px;margin: 0 auto;font-size: 14px; font-weight: 300; color: #c5c5c5;">{{$trace['file']}} Line: {{$trace['line']}}</p>
        @endforeach
    @endif

</div>
<script type="text/javascript" src="{{config('icon.js')}}"></script>
</body>
</html>