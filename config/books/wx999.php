<?php
return [
    'baseUrl' => 'http://www.999wx.com/',
    'charset' => 'gb2312',
    'categorys' => [
        1 => 7,
        2 => 13,
        3 => 17,
        4 => 19,
        5 => 15,
        6 => 25,
        7 => 16,
        8 => 76,
        9 => 18,
    ],
    //小说列表页
    'lists' => [
        //区域选择器
        'range' => '.mainarea .con ul',
        //规则
        'rules' => [
            'title' => [
                'li a.f14','text'
            ],
            'fromurl' => [
                'li a.f14','href'
            ],
            'author'  => [
                'li.ro3 a ','text'
            ],
            //'wordcount'=> [
            //    '.zs','text'
            //],
            'updatetime'=>[
                'li.ro4','text'
            ],
            'zhangjie' => [
                'li a.f14+a','text'
            ]
        ],
        //列表页小说数量
        'pagesize' => 50,
        'pageurl' => 'Book/ShowBookList.aspx?tclassid={catid}&page={page}',
    ],
    //章节列表页
    'detail_list' => [
        //区域选择器
        'range' => '#content .list:eq(1) li',
        //规则
        'rules' => [
            'title' => [
                'a' ,'text'
            ],
            'fromurl' => [
                'a' ,'href'
            ],
        ],
        'pageurl' => 'article/{catid}/{id}/Default.shtml',
    ],
    //详情页
    'content' => [
        'range' => '',
        'rules' => [
            //过滤div和p标签
            'content' => ['#box','text','-p -div -script']
        ]
    ],
];