<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>laravel</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <meta http-equiv="Cache-Control" content="no-transform">
    {{--<meta http-equiv="mobile-agent" content="format=html5; url=http://m.8dushu.com">--}}
    {{--<meta http-equiv="mobile-agent" content="format=xhtml; url=http://m.8dushu.com">--}}
    <link rel="stylesheet" href="/skin/default/css/index.min.css">
    <script type="text/javascript" src="/skin/js/jquery.min.js"></script>
</head>
<body>

@include('home.header')

<div class="yd_ad"></div>

<div class="fengtui">
    @foreach($ftLists as $v)
    <dl>
        <dt><a href="" title="{{ $v['title'] }}"><img src="/skin/default/images/nocover.jpg" alt=""></a></dt>
        <dd><h3><a href="" title="{{ $v['title'] }}">{{  mb_substr($v['title'],0,7) }}</a></h3><span>{{  mb_substr($v['author'],0,5) }}</span><p>    {{  mb_substr($v['introduce'],0,50) }} …</p></dd>
    </dl>
    @endforeach
</div>


@foreach($tjLists as $k => $v)
    @if($k == 1 || $k%4 == 1)
        <div class="tuijian">
    @endif
        <ul class="l">
            <li class="t">
                <h2><a href="" title="{{ $v['catname'] }}">{{ $v['catname'] }}</a></h2>
            </li>
            @foreach($v['data'] as $vv)
            <li><a href="" title="{{ $vv['title'] }}">{{  mb_substr($vv['title'],0,7) }}</a>/{{  mb_substr($vv['author'],0,5) }}</li>
            @endforeach
        </ul>
    @if($k == 4 || $k%4 == 0)
        </div>
    @endif
@endforeach

<div class="main">
    <div class="lastupdate">
        <h2>最新更新</h2>
        <ul>
            <li class="t">
                <span class="lx">类型</span>
                <span class="sm">书名</span>
                <span class="zj">最新章节</span>
                <span class="zz">作者</span>
                <span class="sj">时间</span>
            </li>
            @foreach($newLists as $v)
            <li>
                <span class="lx">[{{  $v['catname'] }}]</span>
                <span class="sm"><a href="" title="{{ $v['title'] }}">{{  mb_substr($v['title'],0,7,'utf-8') }}</a></span>
                <span class="zj"><a href="">{{  mb_substr($v['zhangjie'],0,20,'utf-8') }}</a></span>
                <span class="zz">{{  mb_substr($v['author'],0,5) }}</span>
                <span class="sj">{{ date('m-d',strtotime($v['updated_at'])) }}</span>
            </li>
            @endforeach
        </ul>
    </div>
    <div class="postdate">
        <h2><a href="">新书入库</a></h2>
        <ul>
            @foreach($newInserts as $v)
            <li><span class="lx">[{{ $v['catname'] }}]</span><span class="sm"><a href="" title="{{ $v['title'] }}">{{  mb_substr($v['title'],0,6,'utf-8') }}</a></span><span class="zz">{{  mb_substr($v['author'],0,5) }}</span></li>
            @endforeach
        </ul>
    </div>
</div>

@include('home.footer')

</body>
</html>