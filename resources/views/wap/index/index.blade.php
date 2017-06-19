<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>小说_免费小说_小说在线阅读-{{ $SET['title'] }}手机版</title>
    <meta name="keywords" content="{{ $SET['keywords'] }}">
    <meta name="description" content="{{ $SET['description'] }}">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <meta content="telephone=no" name="format-detection"/>
    <script>
        var docEl = document.documentElement;
        var recalc = function(){
            var clientWidth = docEl.clientWidth;
            if (!clientWidth) return;
            if(clientWidth>=541){
                clientWidth = 541;
            }
            docEl.style.fontSize = 20 * clientWidth/360 + 'px';
        };
        recalc();
        resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
            window.addEventListener(resizeEvt, recalc, false);
    </script>
    <link rel="stylesheet" href="{!! staticPath('/wap/css/index.css') !!}" />
    <script type="text/javascript" src="{!! staticPath('/js/jquery.min.js') !!}"></script>
    <script type="text/javascript" src="{!! staticPath('/js/jquery.lazyload.min.js') !!}"></script>
</head>
<body>

<div class="head">

    <div class="head_logo"></div>

    <div class="head_ulnk">
        {{--<a href="" class="but_search"><em></em></a>--}}
        {{--<a class="but_client" href=""><em>new</em>客户端</a>--}}
    </div>
</div>

<div class="menu">
    <a href="{!! url() !!}" class="active">首页</a>
    <a href="{!! bookurl(3) !!}" >都市</a>
    <a href="{!! bookurl(7) !!}" >科幻</a>
    <a href="{!! bookurl(4) !!}" >穿越</a>
</div>
{{--<div class="olnk"><script type="text/javascript" src="js/161208477713.js"></script></div>--}}

<div id="footprint_id"></div>


{{--<div class="home-slider">--}}
    {{--<div id="J_focus" class="slide_banner">--}}
        {{--<div class="slider-top-wrap J_slideWrap" id="sliderTop">--}}
            {{--<ul class="slider-top-pic">--}}

                {{--<li data-bookId="630235" data-url="/h5/book?bookid=630235&h5=1&fpage=33&fmodule=303&_st=33_303-1_630235">--}}
                    {{--<img src="{!! asset('/skin/wap/picture/1495184753927.jpg') !!}" alt="小李飞刀玄衣行" />--}}
                {{--</li>--}}

                {{--<li data-bookId="564937" data-url="/h5/book?bookid=564937&h5=1&fpage=33&fmodule=303&_st=33_303-2_564937">--}}
                    {{--<img src="{!! asset('/skin/wap/picture/1495184797970.jpg') !!}" alt="独家蜜运：影后初长成" class="lazy_img"/>--}}
                {{--</li>--}}

                {{--<li data-bookId="595772" data-url="/h5/book?bookid=595772&h5=1&fpage=33&fmodule=303&_st=33_303-3_595772">--}}
                    {{--<img src="{!! asset('/skin/wap/picture/1495184915519.jpg') !!}" alt="红馆一姐" class="lazy_img"/>--}}
                {{--</li>--}}

                {{--<li data-bookId="585036" data-url="/h5/book?bookid=585036&h5=1&fpage=33&fmodule=303&_st=33_303-4_585036">--}}
                    {{--<img src="{!! asset('/skin/wap/picture/1495185070475.jpg') !!}" alt="追妻成狂，猎爱小军医" class="lazy_img"/>--}}
                {{--</li>--}}

            {{--</ul>--}}
        {{--</div>--}}
        {{--<div class="indicator">--}}
            {{--<i></i><i></i><i></i><i></i>--}}
        {{--</div>--}}
    {{--</div>--}}



    {{--<div class="flex flex--justify home-fenlei">--}}
        {{--<div class="link-in flex--fluid"><a href=""><em></em><i>免费专区</i></a></div>--}}
        {{--<div class="link-in flex--fluid"><a href=""><em></em><i>女频精选</i></a></div>--}}
    {{--</div>--}}
{{--</div>--}}


<div class="home-card home-top">
    <div class="home-card-title">
        <i class="home-icon-tit home-icon-tit-b"></i>
        <i>编辑力荐</i>
    </div>
    <div class="home-card-con">
        @foreach($ftLists as $v)
        <div class="home-book-item flex border-b touch-a">
            <div class="book-img-border">
                <a href="{!! bookurl($v['catid'],$v['id']) !!}" title="{{ $v['title'] }}">
                    <img src="{!! bookimg($v['thumb']) !!}" alt="{{ $v['title'] }}" class="img-border"/>
                </a>
            </div>
            <div class="book-info-sc flex--fluid">
                <a href="{!! bookurl($v['catid'],$v['id']) !!}" title="{{ $v['title'] }}">
                    <h3 class="font-a">{{ $v['title'] }}</h3>
                    <div class="desc">{{ mb_substr($v['introduce'],0,50) }} …</div>
                    <div class="other flex flex--justify">
                        <i class="author flex--fluid"><em class="author-icon"></em>{{ mb_substr($v['author'],0,5) }}</i>
                        <i class="item-label">{{ $categorys[$v['catid']]['name'] }}</i>
                        <i class="item-state">连载</i>
                    </div>
                </a>
            </div>
        </div>
        @endforeach

    </div>
</div>

{{--<div class="olnk">--}}
    {{--<a href=""><img src="{!! asset('/skin/wap/picture/1495877109653.jpg') !!}"/></a>--}}
{{--</div>--}}

@foreach($tjLists as $k => $v)

    <div class="home-card home-boy" alt="{{ $v['catname'] }}">
        <div class="home-card-title title-mb flex">
            <a href="{!! bookurl($k) !!}" title="{{ $v['catname'] }}">
                <i class="home-icon-tit home-icon-tit-b"></i>
                <i class="flex--fluid">{{ $v['catname'] }}</i>
            </a>
        </div>

        @foreach($v['data'] as $kk => $vv)
            @if($kk == 0 || $kk%3 == 0)
                <div class="home-card-con flex">
            @endif

                    <div class="flex-fluid home-book-box home-book-box-sc touch">
                        <a href="{!! bookurl($k,$vv['id']) !!}" title="{{ $vv['title'] }}">
                            <img src="{!! bookimg($vv['thumb']) !!}" alt="{{ $vv['title'] }}" class="img-border"/>
                            <i class="book-name">{{ mb_substr($vv['title'],0,7) }}</i>
                        </a>
                    </div>

            @if($kk == 2 || ($kk+1)%3 == 0)
                </div>
            @endif
        @endforeach
    </div>

@endforeach

<div class="home-card" alt="热门作品">
    <div class="home-card-title flex">
        <i class="home-icon-tit home-icon-tit-a"></i>
        <i class="flex--fluid">热门作品</i>
    </div>
    @foreach($newLists as $k => $v)
        @if($k == 0)
            <div class="home-book-item flex border-b touch">
                <div class="book-img-border">
                    <a href="{{ bookurl($v['catid'] , $v['id']) }}" title="{{ $v['title'] }}">
                        <img src="{!! bookimg($v['thumb']) !!}" alt="{{ $v['title'] }}" class="img-border"/>
                    </a>
                </div>
                <div class="book-info-sc flex--fluid">
                    <a href="{{ bookurl($v['catid'] , $v['id']) }}" title="{{ $v['title'] }}">
                        <h3 class="font-a">{{ $v['title'] }}</h3>
                        <div class="desc">{{ $v['introduce'] }}</div>
                        <div class="other flex flex--justify">
                            <i class="author flex--fluid"><em class="author-icon"></em>{{ $v['author'] }}</i>
                            <i class="item-label">{{ $v['catname'] }}</i>
                            <i class="item-state">连载</i>
                        </div>
                    </a>
                </div>
            </div>
        @else
            <a class="home-row-line flex touch-a border-b" href="{{ bookurl($v['catid'] , $v['id']) }}" title="{{ $v['title'] }}">
                <span class="flex--fluid">[{{ $v['catname'] }}]{{ $v['title'] }}</span>
                <i class="home-icon-arrow home-row-link"></i>
            </a>
        @endif
    @endforeach
</div>

<div class="home-card" alt="新书精选">
    <div class="home-card-title title-mb flex">
        <i class="home-icon-tit home-icon-tit-b"></i>
        <i class="flex--fluid">新书精选</i>
    </div>
    @foreach($newInserts as $k => $v)
        @if($k == 0 || $k%3 == 0)
            <div class="home-card-con flex">
        @endif
            <div class="flex-fluid home-book-box home-book-box-sc touch" data-bookId="" data-url="">
                <a href="{!! bookurl($v['catid'],$v['id']) !!}" title="{{ $v['title'] }}">
                    <img src="{!! bookimg($v['thumb']) !!}" alt="{{ $v['title'] }}" class="img-border"/>
                    <i class="book-name">{{ $v['title'] }}</i>
                </a>
            </div>
        @if($k == 2 || ($k+1)%3 == 0)
            </div>
        @endif
    @endforeach
</div>
<!-- 新书精选end -->

{{--<div class="home-card" alt="网站公告">--}}
    {{--<div class="home-card-title home-gonggao flex">--}}
        {{--<i class="home-icon-tit home-icon-gonggao"></i>--}}
        {{--<i class="flex--fluid">网站公告</i>--}}
    {{--</div>--}}

    {{--<a class="home-row-line flex touch-a border-b" href="">--}}
        {{--<span class="flex--fluid">4月月票榜冠军关中老人《最强逆袭》</span>--}}
        {{--<i class="home-icon-arrow home-row-link"></i>--}}
    {{--</a>--}}
{{--</div>--}}


@include('wap.footer')


{{--<script type="text/javascript" src="{!! asset('/skin/wap/js/zepto.min.js') !!}"></script>--}}

{{--<script src="{!! asset('/skin/wap/js/swipe.js') !!}"></script>--}}
<script>
    $(function(){
        $("img.lazy").lazyload({
            event : "sporty"
        });
        $(window).bind("load", function() {
            var timeout = setTimeout(function() { $("img.lazy").trigger("sporty"); }, 800);
        });
//        var mfocus = document.querySelector("#J_focus");
//        slide(mfocus).stop();
//        setTimeout(function() {
//            window.GfocusSlide.start();
//        }, 0)
//        function slide(elem) {
//            var wrap = elem.querySelector("div.J_slideWrap"),
//                nav = elem.querySelector("div.indicator");
//            GfocusSlide = swipe(wrap, {
//                auto: 5000,
//                speed: 500,
//                continuous: true,
//                nav: nav
//            });
//            return GfocusSlide
//        }

        //焦点图

//        if(window.devicePixelRatio && window.devicePixelRatio >=2){//判断是否为Retina屏
//            document.querySelector("body").className = "hairlines"
//        }
//        imgload($(".img-border"));
//        bindTouch(".touch,.touch-a","hover")


//        $(".slider-top-pic li,.home-book-item,.home-book-box").click(function(){
//            goBook(this);
//        });
    })
</script>
</body>
</html>