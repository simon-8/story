<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $book['title'] }},{{ $book['title'] }}最新章节,{{ $book['title'] }}无弹窗,{{ $SET['title'] }}</title>
    <meta name="keywords" content="{{ $book['title'] }},{{ $book['title'] }}最新章节,{{ $book['title'] }}无弹窗,{{ $SET['title'] }}">
    <meta name="description" content="{{ $SET['title'] }}为您提供{{ $book['title'] }}最新章节，{{ $book['title'] }}无弹窗。更多{{ $book['title'] }}小说尽在{{ $SET['title'] }}，好看记得告诉您的朋友哦！">
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <meta http-equiv="Cache-Control" content="no-transform">
    <meta http-equiv="mobile-agent" content="format=html5; url={!! wapurl($catid,$id) !!}">
    {{--<meta http-equiv="mobile-agent" content="format=xhtml; url={!! wapurl($catid,$id) !!}">--}}
    <meta property="og:type" content="novel">
    <meta property="og:title" content="{{ $book['title'] }}">
    <meta property="og:description" content="    ”
    各位书友要是觉得《{{ $book['title'] }}》还不错的话请不要忘记向您QQ群和微博里的朋友推荐哦！
">
    <meta property="og:image" content="{{ bookimg($book['thumb']) }}">
    <meta property="og:novel:category" content="{{ $CAT['name'] }}">
    <meta property="og:novel:author" content="{{ $book['author'] }}">
    <meta property="og:novel:book_name" content="{{ $book['title'] }}">
    <meta property="og:novel:read_url" content="{!! Request::getUri() !!}">
    <meta property="og:url" content="{!! Request::getUri() !!}">
    <meta property="og:novel:status" content="连载中">
    <meta property="og:novel:update_time" content="{{ date('m-d',strtotime($book['updated_at'])) }}">
    <meta property="og:novel:latest_chapter_name" content="{{ $lastDetail['title'] }}">
    <meta property="og:novel:latest_chapter_url" content="{!! bookurl($catid,$id,'lastest') !!}"/>
    <link rel="stylesheet" href="{!! staticPath('/default/css/index.min.css') !!}">
    <script type="text/javascript" src="{!! staticPath('/js/jquery.min.js') !!}"></script>
    <script type="text/javascript" src="{!! staticPath('/js/jquery.lazyload.min.js') !!}"></script>
    <script>
        UA = navigator.userAgent.toLowerCase();
        if ((UA.indexOf("iphone") != -1 || UA.indexOf("mobile") != -1 || UA.indexOf("android") != -1 || UA.indexOf("windows ce") != -1 || UA.indexOf("ipod") != -1) && UA.indexOf("ipod") == -1) {
            location.href = '{!! wapurl($catid,$id) !!}';
        }

        function share() {
            document.writeln('<div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a><a href="#" class="bds_sqq" data-cmd="sqq" title="分享到QQ好友"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_isohu" data-cmd="isohu" title="分享到我的搜狐"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_tieba" data-cmd="tieba" title="分享到百度贴吧"></a><a href="#" class="bds_copy" data-cmd="copy" title="分享到复制网址"></a></div>');
            document.writeln('<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"1","bdSize":"24"},"share":{},"image":{"viewList":["weixin","sqq","qzone","tsina","isohu","tqq","renren","tieba","copy"],"viewText":"分享到：","viewSize":"24"}};with(document)0[(getElementsByTagName(\'head\')[0]||body).appendChild(createElement(\'script\')).src=\'http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion=\'+~(-new Date()/36e5)];<\/script>');
        }
    </script>
</head>
<body>

@include('home.header')

<div class="yd_ad">
    {{--<script type="text/javascript">--}}
        {{--var sogou_ad_id=828243;--}}
        {{--var sogou_ad_height=90;--}}
        {{--var sogou_ad_width=960;--}}
    {{--</script>--}}
    {{--<script type='text/javascript' src='http://images.sohu.com/cs/jsfile/js/c.js'></script>--}}
</div>
<div class="place">
    当前位置：<a href="/">{{ $SET['title'] }}</a> > <a href="{!! bookurl($catid) !!}">{{ $CAT['name'] }}</a> > {{ $book['title'] }}
</div>
<div class="jieshao">
    <div class="lf">
        <img src="{!! bookimg($book['thumb']) !!}" alt="{{ $book['title'] }}">
    </div>
    <div class="rt">

        <h1>{{ $book['title'] }}</h1>

        <div class="msg">
            <em>作者：{{ $book['author'] }} </em>
            <em>状态：连载中 </em>
            <em>更新时间：{{ date('m-d',strtotime($book['updated_at'])) }}</em>
            <em>最新章节：
                <a href="{!! bookurl($catid,$id,'lastest') !!}">{{ $book['zhangjie'] }}</a>
            </em>
        </div>
        <div><script>share();</script></div>
        {{--<div class="info">--}}
            {{--<a href="#footer" rel="nofollow">直达底部</a><a target="_blank" rel="nofollow">错误举报</a>投推荐票：--}}
        {{--</div>--}}
        {{--<input type="text" name="uservote_num" id="uservote_num" value="1" maxlength="3"--}}
               {{--onchange="if(/\D/.test(this.value)){alert('只能输入数字');this.value='';}">--}}
        {{--<div class="vote">--}}
            {{--<a id="a_uservote">确定</a>--}}
        {{--</div>--}}

        <div class="intro">
            {{ $book['introduce'] }}
            各位书友要是觉得《{{ $book['title'] }}》还不错的话请不要忘记向您QQ群和微博里的朋友推荐哦！

        </div>
    </div>
    <div class="aside">

    </div>
</div>

{{--<div class="yd_ad">--}}
    {{--<script type="text/javascript">--}}
        {{--var cpro_id = "u2964255";--}}
    {{--</script>--}}
    {{--<script type="text/javascript" src="http://cpro.baidustatic.com/cpro/ui/c.js"></script>--}}
{{--</div>--}}

<div class="mulu">
    <ul>
        @foreach($lists as $v)
            <li><a href="{!! bookurl($catid,$v['pid'],$v['id']) !!}">{{ $v['title'] }}</a></li>
        @endforeach
    </ul>
</div>
<div class="pages" style="text-align:center;">
    {!! $lists->render() !!}
</div>
<div class="yd_ad">

</div>

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