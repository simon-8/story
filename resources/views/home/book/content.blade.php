<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $book['title'] }}, {{ $detail['title'] }},{{ $SET['title'] }}</title>
    <meta name="keywords" content="{{ $book['title'] }},{{ $detail['title'] }},{{ $SET['title'] }}">
    <meta name="description" content=" {{ $detail['title'] }}在线阅读，{{ $book['title'] }}最新章节，{{ $book['title'] }}无弹窗。更多好看的小说尽在{{ $SET['title'] }}！">
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <meta http-equiv="Cache-Control" content="no-transform">
    {{--<meta http-equiv="mobile-agent" content="format=html5; url=http://m.8dushu.com/book/63582-17089407/">--}}
    {{--<meta http-equiv="mobile-agent" content="format=xhtml; url=http://m.8dushu.com/book/63582-17089407/">--}}
    <link rel="stylesheet" href="{!! asset('/skin/default/css/index.min.css') !!}">
    <script type="text/javascript" src="{!! asset('/skin/js/jquery.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/skin/default/js/content.js') !!}"></script>
    <script type="text/javascript">
        //按左右键翻页
        var preview_page = "{!! bookurl($catid,$id,$prevPage['id']) !!}";
        var next_page = "{!! bookurl($catid,$id,$nextPage['id']) !!}";
        var index_page = "{!! bookurl($catid,$id) !!}";
        var article_id = "{{ $id }}";
        var chapter_id = "{{ $aid }}";
        function jumpPage() {
            if (event.keyCode == 37) location = preview_page;
            if (event.keyCode == 39) location = next_page;
            if (event.keyCode == 13) location = index_page;
        }
        document.onkeydown = jumpPage;
    </script>
</head>
<body>
<div class="top">
    <div class="main">
        <div class="lf">

        </div>
        <div class="rt">
            {{--<a href="javascript:st();void 0;" id="st" rel="nofollow">繁體中文</a> |--}}
            <a href="javascript:void(0);" target="_blank">手机版</a> |
            <a href="javascript:void(0);">积分规则</a> |
            <a href="javascript:void(0);" rel="nofollow">放到桌面</a> |
            <a href="javascript:void(0);" onclick="AddFavorite('{{ $SET['title'] }}',location.href)" target="_self" rel="nofollow">收藏本站</a>
        </div>
    </div>
</div>
<div class="yd_ad">

</div>
<div class="read_t">
    当前位置：
    <a href="/">{{ $SET['title'] }}</a> >
    <a href="{!! bookurl($catid) !!}">{{ $CAT['name'] }}</a> >
    <a href="{!! bookurl($catid,$id) !!}">{{ $book['title'] }}</a> >
    {{ $detail['title'] }}
</div>
<div class="read_b">
    {{--<div class="shuqian">--}}
        {{--<a rel="nofollow">加入书架</a>--}}
        {{--<a rel="nofollow">添加书签</a>--}}
        {{--<a href="/newmessage.php?tosys=1&title={{ $book['title'] }} -- {{ $detail['title'] }} 章节出错啦!&content=错误章节： {{ $detail['title'] }} ++++ 举报原因如下： " target="_blank" rel="nofollow">错误举报</a>--}}
        {{--投推荐票：--}}
    {{--</div>--}}
    {{--<input type="text" class="input" name="uservote_num" id="uservote_num" value="1" maxlength="3" onchange="if(/\D/.test(this.value)){alert('只能输入数字');this.value='';}">--}}
    {{--<div class="vote">--}}
        {{--<a id="a_uservote" href="javascript:;" rel="nofollow">确定</a>--}}
    {{--</div>--}}
    <script>bgs()</script>
</div>

<div class="novel">
    <h1> {{ $detail['title'] }}</h1>
    <div class="pereview">
        <a href="{!! bookurl($catid,$id,$prevPage['id']) !!}" target="_top">← 上一章</a>
        <a class="back" href="{!! bookurl($catid,$id) !!}" target="_top">返回目录</a>
        <a href="{!! bookurl($catid,$id,$nextPage['id']) !!}" target="_top">下一章 →</a>
    </div>
    <div class="aside">

    </div>
    <div class="yd_ad2">

    </div>
    <div class="yd_text2">
        {!! $detail['content'] !!}
    </div>
    <div class="yd_ad1">

    </div>
    <div class="pereview">
        <a href="{!! bookurl($catid,$id,$prevPage['id']) !!}" target="_top">← 上一章</a>
        <a class="back" href="{!! bookurl($catid,$id) !!}" target="_top">返回目录</a>
        <a href="{!! bookurl($catid,$id,$nextPage['id']) !!}" target="_top">下一章→</a>
    </div>
    <div class="readacbtn">
        <a class="recommend" href="javascript:void(0);" target="_blank" rel="nofollow">推荐本书</a>
        <a class="favorite" href="javascript:void(0);" rel="nofollow">添加书签</a>
        <a class="bookshelf" href="javascript:void(0);" target="_blank" rel="nofollow">书架</a>
    </div>
</div>

<div class="yd_ad">

</div>

@include('home.footer')
</body>
</html>