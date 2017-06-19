<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $book['title'] }},{{ $book['title'] }}最新章节,{{ $book['title'] }}无弹窗,{{ $SET['title'] }}手机版</title>
    <meta name="keywords" content="{{ $book['title'] }},{{ $book['title'] }}最新章节,{{ $book['title'] }}无弹窗,{{ $SET['title'] }}">
    <meta name="description" content="{{ $SET['title'] }}为您提供{{ $book['title'] }}最新章节，{{ $book['title'] }}无弹窗。更多{{ $book['title'] }}小说尽在{{ $SET['title'] }}，好看记得告诉您的朋友哦！">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <link rel="stylesheet" type="text/css" href="{!! staticPath('/wap/css/mobile.css') !!}">
    {{--<script type="text/javascript" src="{!! staticPath('/wap/js/zepto.min.js') !!}"></script>--}}
    <script type="text/javascript" src="{!! staticPath('/js/jquery.min.js') !!}"></script>
    <script type="text/javascript" src="{!! staticPath('/js/jquery.lazyload.min.js') !!}"></script>
</head>

<body>

<div class="subhead">
    <a href="{!! bookurl($catid) !!}">返回</a>
    <a>本书详情</a>
    <a href="{!! url() !!}" class="">首页</a>
</div>

<div class="booksite">
    <div class="bookimg">

        <img src="{!! bookimg($book['thumb']) !!}" alt="{{ $book['title'] }}">

    </div>
    <div class="bookinfo">
        <h1 class="bookname">{{ $book['title'] }}</h1>
        <div class="info">
            @if($book['author'])<div>作者：<span>{{ $book['author'] }}</span></div>@endif
            <div>分类：<span><a href="{!! bookurl($catid) !!}">{{ $CAT['name'] }}</a></span></div>
            <div>字数：<span>{{ $book['wordcount'] }}</span></div>
            <div>已有 <span>{{ $book['hits'] }}人次</span> 读过此书</div>
        </div>
    </div>

    {{--<a href="#" class="cbut add_bs"></a>--}}

    <div class="bookbutton">

        <a href="{{ bookurl($book['catid'],$book['id'],$lists[0]['id']) }}">立即阅读</a>

        {{--<a id="apkddd" style="border:1px solid #b33836;color:#b33836;background:#f2f2f2;margin-left:8px">离线下载</a>--}}

    </div>

    <div id="lastupdate">
        <em class="vip">最新</em>
        <span class="last_tit"><a href="{!! bookurl($catid, $id , $lastDetail['id']) !!}">{{ $lastDetail['title'] }}</a></span>
        {{--<div class="time">{{ $book['updated_at'] }}</div>--}}
    </div>

</div>


<div class="olnk"></div>

<div class="olnk"></div>

<h3 class="cat_tit2"><em></em>作品简介</h3>
<div class="book_intro">
    {{ $book['introduce'] ? $book['introduce'] : '目前还没有简介哦，直接看精彩的小说内容吧!' }}
    {{--<span id="more_intro"><em>【展开】</em><em style="display:none">【收起】</em></span>--}}
</div>


{{--<div class="book_tags">--}}
{{--<div class="tags_tit">标签：</div>--}}
{{--<div class="tags_wap">--}}

{{--<a href="">扮猪吃虎</a>--}}

{{--<a href="">腹黑</a>--}}

{{--<a href="">豪门恩怨</a>--}}

{{--<a href="">闪婚</a>--}}

{{--<a href="">婚后生活</a>--}}

{{--</div>--}}
{{--</div>--}}
<h3 class="sub_tit">
    <em></em>作品目录
    <span class="org">(共{{ $lists->total() }}章)</span>
    {{--<div id="read_fx" class="read_atz"></div>--}}
</h3>
<div class="book_list" id="coverl_atz">
    @foreach($lists as $v)
        <a href="{!! bookurl($catid,$id,$v['id']) !!}">{{ $v['title'] }}</a>
    @endforeach
</div>
<div class="sbut">
    <a href="{{ bookurl($catid,$id,'chapter') }}" class="view_more">进入作品目录 查看更多</a>
</div>

{{--<h3 class="sub_tit"><em></em>支持本书</h3>--}}
{{--<div class="donate">--}}

    {{--<div class="suply_wap">--}}
        {{--<div>投张推荐票来表达你对本书的态度吧!</div>--}}
        {{--<a href="">投推荐票</a>--}}
    {{--</div>--}}

    {{--<div class="suply_wap">--}}
        {{--<div>更多种方式为作者捧场!</div>--}}
        {{--<a href="">更多捧场</a>--}}
    {{--</div>--}}

{{--</div>--}}


<div class="olnk"></div>


<h3 class="cat_tit">
    <em></em>
    读过{{ $book['title'] }}人还喜欢
    <span class="chanp mbfav_renew">
        <em></em>换一换
    </span>
</h3>

<div class="mbfav_wap">
    @foreach($otherLists as $v)
    <div class="bookbox">
        <div class="bookimg">
            <a href="{!! bookurl($catid,$v['id']) !!}" title="{{ $v['title'] }}">
                <img src="{!! bookimg($v['thumb']) !!}" alt="{{ $v['title'] }}">
            </a>
        </div>
        <div class="bookinfo">
            <a href="{!! bookurl($catid,$v['id']) !!}" title="{{ $v['title'] }}">
                <h4 class="bookname">{{ $v['title'] }}</h4>
                <div class="author">作者：<span>{{ $v['author'] }}</span></div>
                <div class="cat">分类：<span>{{ $CAT['name'] }}</span></div>
                <div class="mbfav_info">
                    <div class="topcor"></div>
                    {{ $v['zhangjie'] }}
                </div>
            </a>
        </div>
    </div>
    @endforeach
</div>

<script>
    //    $("#more_intro").click(function(){
    //        $(this).prev("span").toggle().prev("span").toggle();
    //        $(this).children("em").toggle();
    //        postStat("json","展收简介","vbInfo_"+bookId);
    //    })
    $(".mbfav_renew").click(function(e){
        $that = $(".mbfav_wap");
        for(i=0;i<3;i++){
            var appendbook = $that.children("div").eq(0);
            $that.children("div").eq(0).remove();
            $that.append(appendbook);
        }
    });
</script>
@include('wap.footer')

</body>
</html>