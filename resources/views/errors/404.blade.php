<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]> <html class="no-js" lang="zh_CN"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <title>404错误_天下书屋 - 无弹窗小说阅读网</title>
    <meta name="keywords" content="天下书屋,免费小说,无弹窗,小说分享">
    <meta name="description" content="天下书屋网免费为您提供小说在线阅读服务，没有弹窗广告。为大家分享优质小说！">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <!-- CSS: implied media=all -->
    <link rel="stylesheet" href="{!! staticPath('/default/css/404.css') !!}">
    <script src="{!! staticPath('/js/jquery.min.js') !!}"></script>
    <script>
        $(function(){
            setInterval(function(){
                $('#pacman').toggleClass('pacman_eats');
            }, 300);
            var scrollSpeed = 20;
            var bgscroll = '';
            var direction = 'h';
            var current = 0;
            setInterval(function(){
                current -= 1;
                $('body').css("backgroundPosition", (direction == 'h') ? current+"px 0" : "0 " + current+"px");
            }, scrollSpeed);

        });
    </script>
</head>
<body>

<div id="error-container">
    <div id="error">
        <div id="pacman"></div>
    </div>
    <div id="container">
        <div id="title">
            <h1>对不起, 你访问的页面不存在!</h1>
        </div>
        <div id="content">
            <div class="left">
                <p class="no-top">&nbsp;&nbsp;&nbsp;可能是如下原因引起了这个错误:</p>
                <ul>
                    <li>&nbsp;&nbsp;&nbsp;URL输入错误</li>
                    <li>&nbsp;&nbsp;&nbsp;链接已失效</li>
                    <li>&nbsp;&nbsp;&nbsp;其他原因...</li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="right">
                <p class="no-top">推荐您通过以下链接继续访问本站：</p>
                <ul class="links">
                    <li><a href="/">» 天下书屋网首页</a></li>
                    <!-- <li><a href="{$Think.URL}">» 阅读博文</a></li> -->
                    <!-- <li><a href="{$Think.URL}">» 欣赏图片</a></li> -->
                </ul>
                <!-- 					<ul class="links">
                                        <li><a href="{$Think.URL}">» 人过留名</a></li>
                                        <li><a href="{$Think.URL}">» 腾讯空间</a></li>
                                        <li><a href="{$Think.URL}">» 关于本博</a></li>
                                    </ul> -->
                <div class="clearfix"></div>
            </div>
            <!-- 				// <script type="text/javascript">var cpro_id = "u2688942";</script>
                            // <script type="text/javascript" src="http://cpro.baidustatic.com/cpro/ui/c.js"></script> -->
            <div class="clearfix"></div>
        </div>
        <div id="footer">
            {{--<a href="http://tongji.baidu.com/web/7929482/overview/sole?siteId=6008186" title="百度统计" target="_blank">百度统计</a>&nbsp;|&nbsp;--}}
            <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1261657948'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s4.cnzz.com/z_stat.php%3Fid%3D1261657948%26show%3Dpic' type='text/javascript'%3E%3C/script%3E"));</script>&nbsp;|&nbsp;<a href="http://www.txshu.com/" title="天下书屋">www.txshu.com</a> <span style="float:right">Copyright © 2017 天下书屋网 All Rights Reserved.</span>
        </div>
    </div>
</div>
</body>

</html>