<footer>
    <div class="cl0"></div>

    {{--<form action="" method="GET">--}}
        {{--<div class="searchbox">--}}
            {{--<div>--}}
                {{--<input placeholder="请输入关键字" value="" maxlength="15" name="keywords">--}}
            {{--</div>--}}
            {{--<div class="search_go"></div>--}}
        {{--</div>--}}
        {{--<input type="hidden" name="field" id="field" value="all"/>--}}
    {{--</form>--}}


    {{--<div>--}}
        {{--<a class="active">触屏版</a> |--}}
        {{--<a href="">电脑版</a>--}}
    {{--</div>--}}
    <div class="copyright">本站所有小说由网友上传，如有侵犯版权，请来信告知，本站立即予以处理。</div>

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
</footer>