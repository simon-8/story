<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $CAT['name'] }} - {{ $SET['title'] }}</title>
    <meta name="keywords" content="{{ $SET['keywords'] }}">
    <meta name="description" content="{{ $SET['description'] }}">
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <meta http-equiv="Cache-Control" content="no-transform">
    {{--<meta http-equiv="mobile-agent" content="format=html5; url=http://m.8dushu.com">--}}
    {{--<meta http-equiv="mobile-agent" content="format=xhtml; url=http://m.8dushu.com">--}}
    <link rel="stylesheet" href="{!! asset('/skin/default/css/index.min.css') !!}">
    <script type="text/javascript" src="{!! asset('/skin/js/jquery.min.js') !!}"></script>
</head>
<body>

@include('home.header')

<div class="yd_ad"></div>

<div class="place">
    当前位置：
    <a href="/">{{ $SET['title'] }}</a> >
    <h2>{{ $CAT['name'] }}</h2>
</div>
<div class="fengtui">
    @foreach($ftLists as $v)
        <dl>
            <dt>
                <a href="{!! bookurl($v['catid'],$v['id']) !!}" title="{{ $v['title'] }}">
                    <img src="{!! bookimg($v['thumb']) !!}" alt="{{ $v['title'] }}">
                </a>
            </dt>
            <dd>
                <h3>
                    <a href="{!! bookurl($v['catid'],$v['id']) !!}" title="{{ $v['title'] }}">{{ mb_substr($v['title'],0,7) }}</a>
                </h3>
                <span>{{ mb_substr($v['author'],0,5) }}</span>
                <p>    {{ mb_substr($v['introduce'],0,50) }} …</p>
            </dd>
        </dl>
    @endforeach
</div>

<div class="yd_ad">

</div>

<div class="booklist"><h1>{{ $CAT['name'] }}</h1>
    <ul>
        <li class="t">
            <span class="sm">小说名称</span>
            <span class="zj">最新章节</span>
            <span class="zz">作者</span>
            <span class="zs">字数</span>
            <span class="sj">更新</span>
            <span class="zt">状态</span>
            <span class="fs">关注</span>
        </li>
        @foreach($newLists as $v)
            <li>
            <span class="sm">
                <a href="{!! bookurl($v['catid'],$v['id']) !!}"><b>{{ mb_substr($v['title'],0,15,'utf-8') }}</b></a>
            </span>
                <span class="zj">
                <a href="{!! bookurl($v['catid'],$v['id'],'lastest') !!}">{{ mb_substr($v['zhangjie'],0,20,'utf-8') }}</a>
            </span>
                <span class="zz">{{ mb_substr($v['author'],0,5) }}</span>
                <span class="zs">{{ $v['wordcount'] }}字</span>
                <span class="sj">{{ date('y-m-d',strtotime($v['updated_at'])) }}</span>
                <span class="zt">连载中</span>
                <span class="fs">{{ mt_rand(0,20) }}人</span>
            </li>
        @endforeach
    </ul>
</div>
<div class="pages" style="text-align:center;">
    {!! $newLists->render() !!}
</div>
<div class="yd_ad">

</div>

@include('home.footer')
</body>
</html>