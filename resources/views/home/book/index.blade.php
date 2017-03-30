<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>laravel</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <meta http-equiv="Cache-Control" content="no-transform">
    <link rel="stylesheet" href="/skin/default/css/index.min.css">
    <script type="text/javascript" src="/skin/js/jquery.min.js"></script>
</head>
<body>
@include('home.header')
<div class="yd_ad"></div>
<div class="place">当前位置：<a href="http://www.8dushu.com/">88读书网</a> > <h2>玄幻魔法</h2></div>
<div class="fengtui">
    @foreach($ftLists as $v)
        <dl>
            <dt>
                <a href="{!! route('BookLists',['catid' => $v['catid'] ,'id' => $v['id']]) !!}" title="{{ $v['title'] }}">
                    <img src="{!! bookimg($v['thumb']) !!}" alt="">
                </a>
            </dt>
            <dd>
                <h3>
                    <a href="{!! route('BookLists',['catid' => $v['catid'] ,'id' => $v['id']]) !!}" title="{{ $v['title'] }}">{{  mb_substr($v['title'],0,7) }}</a>
                </h3>
                <span>{{  mb_substr($v['author'],0,5) }}</span>
                <p>    {{  mb_substr($v['introduce'],0,50) }} …</p>
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
                <a href="{!! route('BookContent',['catid' => $CAT['id'] , 'id' => $v['id'] ]) !!}"><b>{{ mb_substr($v['title'],0,15,'utf-8') }}</b></a>
            </span>
                <span class="zj">
                <a href="">{{ mb_substr($v['zhangjie'],0,20,'utf-8') }}</a>
            </span>
                <span class="zz">{{ mb_substr($v['author'],0,5) }}</span>
                <span class="zs">{{ $v['wordcount'] }}字</span>
                <span class="sj">{{ date('y-m-d',strtotime($v['updated_at'])) }}</span>
                <span class="zt">连载中</span>
                <span class="fs">{{ mt_rand(0,20) }}人</span>
            </li>
        @endforeach
    </ul>
    {!! $newLists->render() !!}
</div>
<div class="yd_ad">
</div>
@include('home.footer')
</body>
</html>