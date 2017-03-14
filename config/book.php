<?php
/**
 * Note: 小说配置
 * User: Liu
 * Date: 2017/3/14
 */
return  [
    //栏目分类
    'categorys' => [
        1 => [
            'id' => 1,
            'pid'=> 0,
            'listorder' => 0,
            'items' => 0,
            'name' => '玄幻魔法',
        ],
        2 => [
            'id' => 2,
            'pid'=> 0,
            'listorder' => 0,
            'items' => 0,
            'name' => '武侠修真',
        ],
        3 => [
            'id' => 3,
            'pid'=> 0,
            'listorder' => 0,
            'items' => 0,
            'name' => '都市言情',
        ],
        4 => [
            'id' => 4,
            'pid'=> 0,
            'listorder' => 0,
            'items' => 0,
            'name' => '历史穿越',
        ],
        5 => [
            'id' => 5,
            'pid'=> 0,
            'listorder' => 0,
            'items' => 0,
            'name' => '恐怖悬疑',
        ],
        6 => [
            'id' => 6,
            'pid'=> 0,
            'listorder' => 0,
            'items' => 0,
            'name' => '游戏竞技',
        ],
        7 => [
            'id' => 7,
            'pid'=> 0,
            'listorder' => 0,
            'items' => 0,
            'name' => '军事科幻',
        ],
        8 => [
            'id' => 8,
            'pid'=> 0,
            'listorder' => 0,
            'items' => 0,
            'name' => '综合类型',
        ],
        9 => [
            'id' => 9,
            'pid'=> 0,
            'listorder' => 0,
            'items' => 0,
            'name' => '女生频道',
        ],
    ],
    'rules' => [
        '88dushu'  => [
            //列表页规则
            'lists' => [
                'title' => [
                    '.sm a','text'
                ],
                'linkurl' => [
                    '.sm a','href'
                ],
                'author'  => [
                    '.zz ','text'
                ],
                'wordcount'=> [
                    '.zs','text'
                ],
                'updatetime'=>[
                    '.sj','text'
                ],
                'zhangjie' => [
                    '.zj','text'
                ]
            ],
            'details' => [

            ],
        ]
    ]
];