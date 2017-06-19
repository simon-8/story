<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <title>{{ $book['title'] }}, {{ $detail['title'] }},{{ $SET['title'] }}</title>
    <meta name="keywords" content="{{ $book['title'] }},{{ $detail['title'] }},{{ $SET['title'] }}">
    <meta name="description" content=" {{ $detail['title'] }}在线阅读，{{ $book['title'] }}最新章节，{{ $book['title'] }}无弹窗。更多好看的小说尽在{{ $SET['title'] }}！">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" type="text/css" href="{!! staticPath('/wap/css/reader.css') !!}">
    {{--<link rel="stylesheet" type="text/css" href="http://res.xiaoshuo520.com/css/revision.css?20160908">--}}
</head>
<body class="readbg">
<div class="wrapper">
    <div class="content">
        <h1 class="articletitle">{{ $detail['title'] }}</h1>
        <div class="articleinfo">
            <div class="releaseinfo">{!! date('m-d H:i',strtotime($detail['updated_at'])) !!}&nbsp;更新</div>
            <div class="toolbar">
                <a href="javascript:;" class="pattern" data-role="mode"></a>
                <a href="javascript:;" class="aminus"></a>
                <a href="javascript:;" class="aadd"></a>
            </div>
        </div>
        <div class="articlecon font-large">
            <p>{!! $detail['content'] !!}</p>
        </div>
        <div class="articlebtn">
            @if($prevPage)
                <a href="{!! bookurl($catid,$id,$prevPage['id']) !!}" class="btn">上一章 &lt;</a>
            @else
                <a href="{!! bookurl($catid,$id) !!}" class="btn btn-gray">首页</a>
            @endif
            <a href="{!! bookurl($catid,$id,'chapter') !!}" class="btn">目录</a>
            @if($nextPage)
                <a href="{!! bookurl($catid,$id,$nextPage['id']) !!}" class="btn">下一章 &gt;</a>
            @else
                <a class="btn">没有了</a>
            @endif
        </div>

        <div class="module mt10" style="background: #FFF;">
            <div class="hot">
                @foreach($otherLists as $v)
                <a href="{!! bookurl($v['catid'],$v['id']) !!}"
                   class="line">【{{ $categorys[$v['catid']]['name'] }}】{{ $v['title'] }}</a>
                @endforeach
            </div>
        </div>

    </div>
    <div class="footers">
        {{ $SET['powerby'] }}
    </div>
</div>
<script type="text/javascript" src="{!! staticPath('/wap/js/zepto.min.js') !!}"></script>
<script type="text/javascript" src="{!! staticPath('/wap/js/read.js') !!}"></script>

<div style="display:none;">
    <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1261657948'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s4.cnzz.com/z_stat.php%3Fid%3D1261657948%26show%3Dpic' type='text/javascript'%3E%3C/script%3E"));</script>
</div>

<script>
    (function(){
        var bp = document.createElement('script');
        var curProtocol = window.location.protocol.split(':')[0];
        if (curProtocol === 'https') {
            bp.src = 'https://zz.bdstatic.com/linksubmit/push.js';
        }
        else {
            bp.src = 'http://push.zhanzhang.baidu.com/push.js';
        }
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(bp, s);
    })();
</script>
</body>
</html>