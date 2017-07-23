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
            "spread" => false
        ],
        [
            "title" => "系统基本参数",
            "icon" => "coca-icon coca-icon-xitongpeizhi",
            "href" => 'route[system@config]',
            "spread" => false
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
                    "spread" => false
                ],
                [
                    "title" => "管理员管理",
                    "icon" => "coca-icon coca-icon-guanwangicon31315",
                    "href" => "route[member@index]",
                    "spread" => false
                ],

            ]
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
                    "spread" => false

                ],
                [
                    "title" => "分类管理",
                    "icon" => "coca-icon coca-icon-cloud-classify",
                    "href" => 'route[category@index]',
                    "spread" => false

                ]
            ]
        ],

        [
            "title" => "数据字典",
            "icon" => "coca-icon coca-icon-tubiao17",
            "href" => 'route[dictionary@index]',
            "spread" => false
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