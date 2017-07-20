<?php
return [
    'name' => '后台基础模块', //模块名称
    'description' => '后台基础模块', //模块描述
    'author' => 'rojer', //作者
    'auto' => true, //自动开启
    'menu' => [
        [
            "title" => "后台首页",
            "icon" => "icon-computer",
            "href" => 'route[home]',
            "spread" => false
        ],
        [
            "title" => "系统基本参数",
            "icon" => "&#xe631;",
            "href" => 'route[system@config]',
            "spread" => false
        ],
//        [
//            "title" => "文章列表",
//            "icon" => "icon-text",
//            "href" => "page/news/newsList.html",
//            "spread" => false
//        ],

        [
            'title' => '角色与权限',
            "icon" => "&#xe627;",
            "href" => "",
            "spread" => false,
            'children' => [
                [
                    "title" => "角色管理",
                    "icon" => "&#xe612;",
                    "href" => 'route[role@index]',
                    "spread" => false
                ],
                [
                    "title" => "管理员管理",
                    "icon" => "&#xe613;",
                    "href" => "route[member@index]",
                    "spread" => false
                ],

            ]
        ],
        [
            "title" => "友情链接",
            "icon" => "&#xe64c;",
            "href" => "page/links/linksList.html",
            "spread" => false
        ],
//        [
//            "title" => "其他页面",
//            "icon" => "&#xe630;",
//            "href" => "",
//            "spread" => false,
//            "children" => [
//                [
//                    "title" => "404页面",
//                    "icon" => "&#xe61c;",
//                    "href" => "page/404.html",
//                    "spread" => false
//                ],
//                [
//                    "title" => "登录",
//                    "icon" => "&#xe609;",
//                    "href" => "page/login/login.html",
//                    "spread" => false,
//                    "target" => "_blank"
//                ]
//            ]
//        ]
    ]
];