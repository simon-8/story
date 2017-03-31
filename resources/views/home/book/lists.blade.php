<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <meta http-equiv="Cache-Control" content="no-transform">
    <meta charset="utf-8">
    <title>{{ $book['title'] }}</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    {{--<meta http-equiv="mobile-agent" content="format=html5; url=http://m.8dushu.com/info/63582/">--}}
    {{--<meta http-equiv="mobile-agent" content="format=xhtml; url=http://m.8dushu.com/info/63582/">--}}
    <meta property="og:type" content="novel">
    <meta property="og:title" content="">
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
    <meta property="og:novel:latest_chapter_url" content="{!! bookurl($catid,$id,$lastDetail['id']) !!}"/>
    <link rel="stylesheet" href="{!! asset('/skin/default/css/index.min.css') !!}">
    <script type="text/javascript" src="{!! asset('/skin/js/jquery.min.js') !!}"></script>
</head>
<body>

@include('home.header')

<div class="yd_ad">

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
                <a href="">{{ $book['zhangjie'] }}</a>
            </em>
        </div>
        <div class="info">
            <a href="#footer" rel="nofollow">直达底部</a><a target="_blank" rel="nofollow">错误举报</a>投推荐票：
        </div>
        <input type="text" name="uservote_num" id="uservote_num" value="1" maxlength="3"
               onchange="if(/\D/.test(this.value)){alert('只能输入数字');this.value='';}">
        <div class="vote">
            <a id="a_uservote">确定</a>
        </div>

        <div class="intro">
            {{ $book['introduce'] }}
            各位书友要是觉得《{{ $book['title'] }}》还不错的话请不要忘记向您QQ群和微博里的朋友推荐哦！

        </div>
    </div>
    <div class="aside">

    </div>
</div>
<div class="yd_ad">

</div>
<div class="mulu">
    <ul>
        @foreach($lists as $v)
            <li><a href="{!! bookurl($catid,$v['pid'],$v['id']) !!}">{{ $v['title'] }}</a></li>
        @endforeach
    </ul>
</div>
<div class="yd_ad">

</div>

@include('home.footer')

</body>
</html>