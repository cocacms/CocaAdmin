<?php
return [
    'name' => '后台基础模块', //模块名称
    'description' => '后台基础模块', //模块描述
    'author' => 'rojer', //作者
    'auto' => true, //自动开启
    'menu' => [
        [
            "title" => "后台首页",
            "icon" => "iconfont icon-computer",
            "href" => 'route[home]',
            "spread" => false,
        ],
        [
            "title" => "系统基本参数",
            "icon" => "coca-icon coca-icon-xitongpeizhi",
            "href" => 'route[system@config]',
            "spread" => false,
        ],

        [
            'title' => '角色与权限',
            "icon" => "coca-icon coca-icon-quanxian2",
            "href" => "",
            "spread" => false,
            'children' => [
                [
                    "title" => "角色管理",
                    "icon" => "coca-icon coca-icon-quanxian5",
                    "href" => 'route[role@index]',
                    "spread" => false,
                    "index" => 1
                ],
                [
                    "title" => "管理员管理",
                    "icon" => "coca-icon coca-icon-guanwangicon31315",
                    "href" => "route[member@index]",
                    "spread" => false,
                    "index" => 0
                ],

            ],
            "index" => 998
        ],
        [
            "title" => "分类管理",
            "icon" => "coca-icon coca-icon-cloud-classify",
            "href" => "",
            "spread" => false,
            "children" => [
                [
                    "title" => "分类域管理",
                    "icon" => "coca-icon coca-icon-fenleizukuaier",
                    "href" => 'route[category@rootIndex]',
                    "spread" => false,
                    "index" => 1

                ],
                [
                    "title" => "分类管理",
                    "icon" => "coca-icon coca-icon-cloud-classify",
                    "href" => 'route[category@index]',
                    "spread" => false,
                    "index" => 0

                ]
            ],
            'index'=>2
        ],
        [
            "title" => "模块管理",
            "icon" => "coca-icon coca-icon-fenleizukuaier",
            "href" => 'route[module@index]',
            "spread" => false,
            'index'=> 3
        ],
        [
            "title" => "其他功能",
            "icon" => "coca-icon coca-icon-tubiaozhizuomobanzizhi-copy",
            "href" => '',
            "spread" => false,
            "children" =>[
                [
                    "title" => "数据字典",
                    "icon" => "coca-icon coca-icon-tubiao17",
                    "href" => 'route[dictionary@index]',
                    "spread" => false,

                ],
                [
                    "title" => "宣传滚动栏",
                    "icon" => "coca-icon coca-icon-tubiaozhizuomoban-",
                    "href" => 'route[promo@index]',
                    "spread" => false
                ],

                [
                    "title" => "广告管理",
                    "icon" => "coca-icon coca-icon-guanggao1",
                    "href" => 'route[ad@index]',
                    "spread" => false
                ],
            ],
            "index" => 999
        ],


    ],
    'temp'=>[
        'layui' => // 模板使用数组 或者 文字{"code": ${code},"msg": "${msg}","data": {"src": "${data}"}}
            [
                'code'=> '${code}',
                'msg' => '${msg}',
                'data' => [
                    'src' => '${data}'
                ]
            ]
    ]
];