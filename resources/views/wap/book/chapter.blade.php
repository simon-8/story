<html>
<head>
    <meta charset="utf-8">
    <title>{{ $book['title'] }}最新章节列表_{{ $book['title'] }}全文阅读-{{ $SET['title'] }}手机版</title>
    <meta name="keywords" content="{{ $book['title'] }}最新章节列表, {{ $book['title'] }}全文阅读">
    <meta name="description"
          content="《{{ $book['title'] }}》最新章节列表与{{ $book['title'] }}全文阅读尽在{{ $SET['title'] }}。">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" type="text/css" href="{!! staticPath('/wap/css/mobile.css') !!}">
    {{--<script type="text/javascript" src="{!! asset('/skin/wap/js/zepto.min.js') !!}"></script>--}}
</head>
<body>
<div class="olnk"></div>

<div class="subhead">
    <a href="{!! bookurl($catid,$id) !!}">返回</a>
    <a>目录<span class="sf">(共{{ $lists->total() }}章)</span></a>
    <a href="{!! url() !!}" class="">首页</a>
</div>

<div class="olnk"></div>

<div class="book_list" id="cplist_wap">
    @foreach($lists as $v)
        <a href="{!! bookurl($catid,$v['pid'],$v['id']) !!}" title="{{ $v['title'] }}_{{ $book['title'] }}">{{ $v['title'] }}</a>
    @endforeach

</div>

<div class="olnk"></div>

<div class="pages" style="text-align:center;">
    {!! $lists->render() !!}
</div>

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