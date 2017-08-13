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
    <link rel="stylesheet" href="{{asset('web/css/app.css?v=2')}}" media="all" />

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
            @foreach(pagers_by_category_ids($category_helper->getIds('header')) as $pager)

                <li>
                    <a href="{{is_null($pager->jump) ? route('pager@showById',['id' => $pager->id]) : route_parse($pager->jump)}}">{{$pager->name}}</a>
                    @if(isset($pager->additional['category_root']))
                        @php
                            $trees = \Module\AdminBase\Models\Category::where('tag', '=', $pager->additional['category_root'])->first()->getDescendants()->toHierarchy();

                            function index_category_tree_build_fun ($tree,$pager){
                                $child = "";
                                if($tree->children && $tree->children->count() > 0){
                                    $child .= "<ul class=\"child\">";
                                    foreach ($tree->children as $children){
                                        $child .= index_category_tree_build_fun($children,$pager);
                                    }
                                    $child .= "</ul>";

                                }
                                $link = is_null($pager->jump) ? route('pager@showById',['id' => $pager->id , 'category' => $tree->id ]) : route_parse($pager->jump);
                                $html = "
                                <li class=\"child-item\">
                                <a href=\"$link\">$tree->name</a>
                                $child
                                </li>";
                                return $html;
                            }

                        @endphp
                        <ul class="child">
                        @foreach($trees as $tree)
                            {!! index_category_tree_build_fun($tree,$pager) !!}
                        @endforeach
                        </ul>

                    @endif
                </li>
            @endforeach
        </ul>
        <ul class="login am-hide-sm">
            @if(is_null($_user))
                <li>
                    <a href="{{route('web@login')}}">登录账户</a>
                </li>
            @else
                <li>
                    <a href="{{route('order@my')}}">{{$_user->nickname or $_user->username}}</a>
                </li>
                <li>
                    <a href="{{route('web@logout')}}"> 退出</a>
                </li>
            @endif


            <li>
                <a href="{{route('cart@index')}}"><span class="am-icon-shopping-cart"></span></a>
            </li>
        </ul>

        <div class="search-bar am-show-lg">
            <form id="_search" action="{{route('product@web@search')}}" method="post">
                <i class="am-icon-search"></i>
                {{csrf_field()}}
                <input name="_search" type="text" placeholder="请输入关键字搜索商品" value="{{request()->input('_search','')}}">
                <input type="submit" style="display: none">
            </form>
        </div>
        <div class="login" onclick="javascript:void(0);" data-am-offcanvas="{target: '#header-bars', effect: 'push'}">
            <span class="am-icon-bars am-show-sm am-icon-sm"></span>
        </div>
    </div>
</div>


<!-- 侧边栏内容 -->
<div id="header-bars" class="am-offcanvas">
    <div class="am-offcanvas-bar am-offcanvas-bar-flip">
        <div class="am-offcanvas-content">
            <ul>

                @if(is_null($_user))
                    <li>
                        <a href="{{route('web@login')}}">登录账户</a>
                    </li>
                    @foreach(pagers_by_category_ids($category_helper->getIds('header')) as $pager)
                        <li><a href="{{is_null($pager->jump) ? route('pager@showById',['id' => $pager->id]) : route_parse($pager->jump)}}">{{$pager->name}}</a></li>
                    @endforeach
                @else
                    <li>
                        <a href="{{route('order@my')}}">{{$_user->nickname or $_user->username}}</a>
                    </li>
                    @foreach(pagers_by_category_ids($category_helper->getIds('header')) as $pager)
                        <li><a href="{{is_null($pager->jump) ? route('pager@showById',['id' => $pager->id]) : route_parse($pager->jump)}}">{{$pager->name}}</a></li>
                    @endforeach
                    <li>
                        <a href="{{route('web@logout')}}"> 退出</a>
                    </li>
                @endif

            </ul>
        </div>
    </div>
</div>


<div data-am-widget="navbar" class="am-navbar am-cf am-navbar-default am-show-sm" id="">
    <ul class="am-navbar-nav am-cf am-avg-sm-4">
        <li >
            <a href="{{route('pager@home')}}" class="">
                <span class="am-icon-home"></span>
                <span class="am-navbar-label">首页</span>
            </a>
        </li>

        <li >
            <a href="{{route('pager@showByTag',['tag'=>'product-list'])}}" class="">
                <span class="am-icon-gift"></span>
                <span class="am-navbar-label">产品</span>
            </a>
        </li>

        <li >
            <a href="{{route('cart@index')}}" class="">
                <span class="am-icon-shopping-cart"></span>
                <span class="am-navbar-label">购物车</span>
            </a>
        </li>
        <li >
            <a href="{{route('order@my')}}" class="">
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

    $(document).ajaxComplete(function(event, xhr, settings){
        if(xhr.status == 401){
            alert('请先登录！')
        }
    });

    $("#_search input").keydown(function(event){
        if(event.keyCode ==13){
            $("#_search [type=submit]").trigger("click");
        }
    });

    function handle() {
        var width = $(this).width();
        $(this).children(".child").css('left',(width + 11 )+'px');
    }
    $('.nav .child-item').hover(handle);
    $('.nav .child-item').focus(handle);

</script>
</body>
</html>