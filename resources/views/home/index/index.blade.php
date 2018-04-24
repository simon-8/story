<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $SET['title'] }}</title>
    <meta name="keywords" content="{{ $SET['keywords'] }}">
    <meta name="description" content="{{ $SET['description'] }}">
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <meta http-equiv="Cache-Control" content="no-transform">
    <meta http-equiv="mobile-agent" content="format=html5; url={!! wapurl() !!}">
    {{--<meta http-equiv="mobile-agent" content="format=xhtml; url={!! wapurl() !!}">--}}
    <link rel="stylesheet" href="{!! staticPath('/default/css/index.min.css') !!}">
    <script type="text/javascript" src="{!! staticPath('/js/jquery.min.js') !!}"></script>
    <script type="text/javascript" src="{!! staticPath('/js/jquery.lazyload.min.js') !!}"></script>
    <script>
        UA = navigator.userAgent.toLowerCase();
        if ((UA.indexOf("iphone") != -1 || UA.indexOf("mobile") != -1 || UA.indexOf("android") != -1 || UA.indexOf("windows ce") != -1 || UA.indexOf("ipod") != -1) && UA.indexOf("ipod") == -1) {
            location.href = '{!! wapurl() !!}';
        }
    </script>
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({
            google_ad_client: "ca-pub-2039171390518102",
            enable_page_level_ads: true
        });
    </script>
</head>
<body>

@include('home.header')

<div class="yd_ad"></div>

<div class="fengtui">
    @foreach($ftLists as $v)
    <dl>
        <dt>
            <a href="{!! bookurl($v['catid'],$v['id']) !!}" title="{{ $v['title'] }}"><img src="{!! bookimg($v['thumb']) !!}" alt="{{ $v['title'] }}"></a>
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


@foreach($tjLists as $k => $v)
    @if($k == 1 || $k%4 == 1)
        <div class="tuijian">
    @endif
        <ul @if($k == 1 || $k%4 == 1) class="l" @endif>
            <li class="t">
                <h2><a href="{!! bookurl($v['id']) !!}" title="{{ $v['catname'] }}">{{ $v['catname'] }}</a></h2>
            </li>
            @foreach($v['data'] as $vv)
            <li><a href="{!! bookurl($vv['catid'],$vv['id']) !!}" title="{{ $vv['title'] }}">{{ mb_substr($vv['title'],0,7) }}</a>/{{ mb_substr($vv['author'],0,5) }}</li>
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
                <span class="lx">[<a href="{!! bookurl($v['catid']) !!}">{{ $v['catname'] }}</a>]</span>
                <span class="sm">
                    <a href="{!! bookurl($v['catid'],$v['id']) !!}" title="{{ $v['title'] }}">{{ mb_substr($v['title'],0,7,'utf-8') }}</a>
                </span>
                <span class="zj">
                    <a href="{!! bookurl($v['catid'],$v['id'],'lastest') !!}">{{ $v['zhangjie'] ? mb_substr($v['zhangjie'],0,20,'utf-8') : '&nbsp;' }}</a>
                </span>
                <span class="zz">{{ $v['author'] ? mb_substr($v['author'],0,5) : '&nbsp;' }}</span>
                <span class="sj">{{ date('m-d',strtotime($v['updated_at'])) }}</span>
            </li>
            @endforeach
        </ul>
    </div>
    <div class="postdate">
        <h2><a href="javascript:void(0);">新书入库</a></h2>
        <ul>
            @foreach($newInserts as $v)
                <li>
                    <span class="lx">[<a href="{!! bookurl($v['catid']) !!}">{{ $v['catname'] }}</a>]</span>
                    <span class="sm">
                        <a href="{!! bookurl($v['catid'],$v['id']) !!}" title="{{ $v['title'] }}">{{ mb_substr($v['title'],0,6,'utf-8') }}</a>
                    </span>
                    <span class="zz">{{ mb_substr($v['author'],0,5) }}</span>
                </li>
            @endforeach
        </ul>
    </div>
</div>

@if(count($firendLinks))
    <div class="link">
        友情链接：
        @foreach($firendLinks as $v)
            <a href="{!! $v['linkurl'] !!}" target="_blank">{{ $v['title'] }}</a>
        @endforeach
    </div>
@endif

{{--<div class="yd_ad">--}}
    {{--<script type="text/javascript">--}}
        {{--var cpro_id = "u2964255";--}}
    {{--</script>--}}
    {{--<script type="text/javascript" src="http://cpro.baidustatic.com/cpro/ui/c.js"></script>--}}
{{--</div>--}}

@include('home.footer')
<script>
    $(function(){
        $("img.lazy").lazyload({
            event : "sporty"
        });
        $(window).bind("load", function() {
            var timeout = setTimeout(function() { $("img.lazy").trigger("sporty"); }, 800);
        });
    });
</script>
</body>
</html>