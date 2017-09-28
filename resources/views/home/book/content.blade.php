<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $book['title'] }}, {{ $detail['title'] }},{{ $SET['title'] }}</title>
    <meta name="keywords" content="{{ $book['title'] }},{{ $detail['title'] }},{{ $SET['title'] }}">
    <meta name="description" content=" {{ $detail['title'] }}在线阅读，{{ $book['title'] }}最新章节，{{ $book['title'] }}无弹窗。更多好看的小说尽在{{ $SET['title'] }}！">
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <meta http-equiv="Cache-Control" content="no-transform">
    <meta http-equiv="mobile-agent" content="format=html5; url={!! wapurl($catid,$id,$detail['id']) !!}">
    {{--<meta http-equiv="mobile-agent" content="format=xhtml; url={!! wapurl($catid,$id,$detail['id']) !!}">--}}
    <link rel="stylesheet" href="{!! staticPath('/default/css/index.min.css') !!}">
    <script type="text/javascript" src="{!! staticPath('/js/jquery.min.js') !!}"></script>
    <script type="text/javascript" src="{!! staticPath('/default/js/content.js') !!}"></script>
    <script type="text/javascript">
        UA = navigator.userAgent.toLowerCase();
        if ((UA.indexOf("iphone") != -1 || UA.indexOf("mobile") != -1 || UA.indexOf("android") != -1 || UA.indexOf("windows ce") != -1 || UA.indexOf("ipod") != -1) && UA.indexOf("ipod") == -1) {
            location.href = '{!! wapurl($catid,$id,$detail['id']) !!}';
        }

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
            <a href="{!! wapurl() !!}" target="_blank">手机版</a> |
            {{--<a href="javascript:void(0);">积分规则</a> |--}}
            {{--<a href="javascript:void(0);" rel="nofollow">放到桌面</a> |--}}
            <a href="javascript:void(0);" onclick="AddFavorite('{{ $SET['title'] }}',location.href)" target="_self" rel="nofollow">收藏本站</a>
        </div>
    </div>
</div>
<div class="yd_ad">
    {{--<script type="text/javascript">--}}
        {{--var sogou_ad_id=828244;--}}
        {{--var sogou_ad_height=90;--}}
        {{--var sogou_ad_width=960;--}}
    {{--</script>--}}
    {{--<script type='text/javascript' src='http://images.sohu.com/cs/jsfile/js/c.js'></script>--}}

</div>
<div class="read_t">
    <span>
        <script>share();</script>
    </span>
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
    <div class="bgs">
        <ul>
            <li>
                <input type="text" class="textm" id="screen" value="滚屏">
                <input type="hidden" class="textm" id="screen2" value="滚屏">
                <span class="btn" id="screen1"></span>
            </li>
            <li class="select">
                <p>0</p>
                <p>1慢</p>
                <p>2</p>
                <p>3</p>
                <p>4</p>
            </li>
        </ul>
        <ul>
            <li>
                <input type="text" class="textm" id="background" value="背景"/>
                <input type="hidden" id="background2" value="#000"/>
                <span class="btn" id="background1"></span>
            </li>
            <li class="select">
                <p class="bg_huang">明黄</p>
                <p class="bg_lan">淡蓝</p>
                <p class="bg_lv">淡绿</p>
                <p class="bg_fen">红粉</p>
                <p class="bg_bai">白色</p>
                <p class="bg_hui">灰色</p>
                <p class="bg_hei">漆黑</p>
                <p class="bg_cao">草绿</p>
                <p class="bg_cha">茶色</p>
                <p class="bg_yin">银色</p>
                <p class="bg_mi">米色</p>
            </li>
        </ul>
        <ul>
            <li>
                <input type="text" class="textm" id="fontSize" value="字号"/>
                <input type="hidden" id="fontSize2" value="16px"/>
                <span class="btn" id="fontSize1"></span>
            </li>
            <li class="select">
                <p class="fon_12">12px</p>
                <p class="fon_14">14px</p>
                <p class="fon_16">16px</p>
                <p class="fon_18">18px</p>
                <p class="fon_20">20px</p>
                <p class="fon_24">24px</p>
                <p class="fon_30">30px</p>
            </li>
        </ul>
        <ul>
            <li>
                <input type="text" class="textm" id="fontColor" value="字色"/>
                <input type="hidden" id="fontColor2" value="z_mo"/>
                <span class="btn" id="fontColor1"></span>
            </li>
            <li class="select">
                <p class="z_hei">黑色</p>
                <p class="z_red">红色</p>
                <p class="z_lan">蓝色</p>
                <p class="z_lv">绿色</p>
                <p class="z_hui">灰色</p>
                <p class="z_li">栗色</p>
                <p class="z_wu">雾白</p>
                <p class="z_zi">暗紫</p>
                <p class="z_he">玫褐</p>
            </li>
        </ul>
        <ul>
            <li>
                <input type="text" class="textm" id="fontFamily" value="字体"/>
                <input type="hidden" id="fontFamily2" value="fam_song"/>
                <span class="btn" id="fontFamily1"></span>
            </li>
            <li class="select"><p class="fam_song">宋体</p>
                <p class="fam_hei">黑体</p>
                <p class="fam_kai">楷体</p>
                <p class="fam_qi">启体</p>
                <p class="fam_ya">雅黑</p></li>
        </ul>
        <input type="button" class="ud_but2" onmousemove="this.className='ud_but22'" onmouseout="this.className='ud_but2'" value="保存" id="saveButton"/>
        <input type="button" class="ud_but1" onmousemove="this.className='ud_but11'" onmouseout="this.className='ud_but1'" value="恢复" id="recoveryButton"/>
    </div>
</div>

<div class="novel">
    <h1> {{ $detail['title'] }}</h1>
    <div class="pereview">
        <a href="{!! bookurl($catid,$id,$prevPage['id']) !!}" target="_top">← 上一章</a>
        <a class="back" href="{!! bookurl($catid,$id) !!}" target="_top">返回目录</a>
        <a href="{!! bookurl($catid,$id,$nextPage['id']) !!}" target="_top">下一章 →</a>
    </div>
    <div class="aside">
        因最近服务器数据更新，部分书籍最新章节异常，正紧急修复中，对您造成的不便，请谅解。
    </div>
    <div class="yd_ad2">
        <span>
            {{--<script type="text/javascript">--}}
                {{--var cpro_id = "u2966008";--}}
            {{--</script>--}}
            {{--<script type="text/javascript" src="http://cpro.baidustatic.com/cpro/ui/c.js"></script>--}}
        </span>
        <span>
            {{--<script type="text/javascript">--}}
                {{--var sogou_ad_id=828226;--}}
                {{--var sogou_ad_height=250;--}}
                {{--var sogou_ad_width=300;--}}
            {{--</script>--}}
            {{--<script type='text/javascript' src='http://images.sohu.com/cs/jsfile/js/c.js'></script>--}}
        </span>
        <span>
            {{--<script type="text/javascript">--}}
                {{--var cpro_id = "u2966016";--}}
            {{--</script>--}}
            {{--<script type="text/javascript" src="http://cpro.baidustatic.com/cpro/ui/c.js"></script>--}}
        </span>
    </div>
    <div class="yd_text2">
        {!! $detail['content'] !!}
    </div>
    <div class="yd_ad1">
        {{--<script type="text/javascript">--}}
            {{--var sogou_ad_id=828236;--}}
            {{--var sogou_ad_height=90;--}}
            {{--var sogou_ad_width=760;--}}
        {{--</script>--}}
        {{--<script type='text/javascript' src='http://images.sohu.com/cs/jsfile/js/c.js'></script>--}}
    </div>
    <div class="pereview">
        <a href="{!! bookurl($catid,$id,$prevPage['id']) !!}" target="_top">← 上一章</a>
        <a class="back" href="{!! bookurl($catid,$id) !!}" target="_top">返回目录</a>
        <a href="{!! bookurl($catid,$id,$nextPage['id']) !!}" target="_top">下一章→</a>
    </div>
    {{--<div class="readacbtn">--}}
        {{--<a class="recommend" href="javascript:void(0);" target="_blank" rel="nofollow">推荐本书</a>--}}
        {{--<a class="favorite" href="javascript:void(0);" rel="nofollow">添加书签</a>--}}
        {{--<a class="bookshelf" href="javascript:void(0);" target="_blank" rel="nofollow">书架</a>--}}
    {{--</div>--}}
</div>

{{--<div class="yd_ad">--}}
    {{--<script type="text/javascript">--}}
        {{--var cpro_id = "u2964255";--}}
    {{--</script>--}}
    {{--<script type="text/javascript" src="http://cpro.baidustatic.com/cpro/ui/c.js"></script>--}}
{{--</div>--}}

@include('home.footer')
</body>
</html>