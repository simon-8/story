<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $CAT['name'] }} - {{ $SET['title'] }}手机版</title>
    <meta name="keywords" content="{{ $SET['keywords'] }}">
    <meta name="description" content="{{ $SET['description'] }}">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <link rel="stylesheet" type="text/css" href="{!! staticPath('/wap/css/mobile.css') !!}">
    <script type="text/javascript" src="{!! staticPath('/js/jquery.min.js') !!}"></script>
    <script type="text/javascript" src="{!! staticPath('/js/jquery.lazyload.min.js') !!}"></script>
    {{--<script type="text/javascript" src="{!! asset('/skin/wap/js/zepto.min.js') !!}"></script>--}}
</head>

<body>


<div class="subhead">
    <a href="{!! url() !!}">返回</a>
    <a>{{ $CAT['name'] }}</a>
    <a href="{!! url() !!}" class="">首页</a>
</div>
<h2 class="cat_tit"><em></em>{{ $CAT['name'] }}</h2>

<div class="tab_tit" id="cat_subtab">
    @foreach($categorys as $v)
        @if($catid != $v['id'])
            <span><a href="{!! bookurl($v['id']) !!}" title="{{ $v['name'] }}">{{ $v['name'] }}</a></span>
        @endif
    @endforeach
    <div class="clear" style="clear:both;">&nbsp;</div>
</div>
<div id="cateList_wap" class="book_slist">
    @foreach($newLists as $v)
    <div class="bookbox">
        <div class="bookimg">
            <a href="{!! bookurl($v['catid'],$v['id']) !!}" title="{{ $v['title'] }}">
                <img src="{!! bookimg($v['thumb']) !!}" alt="{{ $v['title'] }}">
            </a>
        </div>
        <div class="bookinfo">
            <a href="{!! bookurl($v['catid'],$v['id']) !!}" title="{{ $v['title'] }}">
                <h4 class="bookname">{{ mb_substr($v['title'],0,15,'utf-8') }}</h4>
                <div class="author">作者：{{ mb_substr($v['author'],0,5) }}</div>
                <div class="cat">{{ $categorys[$v['catid']]['name'] }}</div>
                <div class="cl0"></div>
                <div class="update"><span>更新至：</span>{{ mb_substr($v['zhangjie'],0,20,'utf-8') }}</div>
                <div class="intro_line">
                    <span>简介：</span>
                    {{ mb_substr($v['introduce'],0,50) }}
                </div>
            </a>
        </div>
    </div>
    @endforeach
</div>
<div class="pages" style="text-align:center;">
    {!! $newLists->render() !!}
</div>

@include('wap.footer')

</body>
</html>