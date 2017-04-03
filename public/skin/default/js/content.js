var date = new Date();
var timestamp = Date.parse(new Date());
date.setTime(date.getTime() + (30 * 24 * 60 * 60 * 1000));
jQuery.cookie = function(b, j, m) {
    if (typeof j != "undefined") {
        m = m || {};
        if (j === null) {
            j = "";
            m.expires = -1
        }
        var e = "";
        if (m.expires && (typeof m.expires == "number" || m.expires.toUTCString)) {
            var f;
            if (typeof m.expires == "number") {
                f = new Date();
                f.setTime(f.getTime() + (m.expires * 24 * 60 * 60 * 1000))
            } else {
                f = m.expires
            }
            e = "; expires=" + f.toUTCString()
        }
        var l = m.path ? "; path=" + (m.path) : "";
        var g = m.domain ? "; domain=" + (m.domain) : "";
        var a = m.secure ? "; secure": "";
        document.cookie = [b, "=", encodeURIComponent(j), e, l, g, a].join("")
    } else {
        var d = null;
        if (document.cookie && document.cookie != "") {
            var k = document.cookie.split(";");
            for (var h = 0; h < k.length; h++) {
                var c = jQuery.trim(k[h]);
                if (c.substring(0, b.length + 1) == (b + "=")) {
                    d = decodeURIComponent(c.substring(b.length + 1));
                    break
                }
            }
        }
        return d
    }
};
function share() {
    document.writeln('<div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a><a href="#" class="bds_sqq" data-cmd="sqq" title="分享到QQ好友"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_isohu" data-cmd="isohu" title="分享到我的搜狐"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_tieba" data-cmd="tieba" title="分享到百度贴吧"></a><a href="#" class="bds_copy" data-cmd="copy" title="分享到复制网址"></a></div>');
    document.writeln('<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"1","bdSize":"24"},"share":{},"image":{"viewList":["weixin","sqq","qzone","tsina","isohu","tqq","renren","tieba","copy"],"viewText":"分享到：","viewSize":"24"}};with(document)0[(getElementsByTagName(\'head\')[0]||body).appendChild(createElement(\'script\')).src=\'http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion=\'+~(-new Date()/36e5)];<\/script>');
}
function bgs() {
    document.writeln('<div class="bgs"><ul><li><input type="text" class="textm" id="screen" value="滚屏"><input type="hidden" class="textm" id="screen2" value="滚屏"><span class="btn" id="screen1"></span></li><li class="select"><p>0</p><p>1慢</p><p>2</p><p>3</p><p>4</p></li></ul>');
    document.writeln('<ul><li><input type="text" class="textm" id="background" value="背景"  /><input type="hidden" id="background2" value="#000" /><span class="btn" id="background1"></span></li><li class="select"><p class="bg_huang">明黄</p><p class="bg_lan">淡蓝</p><p class="bg_lv">淡绿</p><p class="bg_fen">红粉</p><p class="bg_bai">白色</p><p class="bg_hui">灰色</p><p class="bg_hei">漆黑</p><p class="bg_cao">草绿</p><p class="bg_cha">茶色</p><p class="bg_yin">银色</p><p class="bg_mi">米色</p></li></ul>');
    document.writeln('<ul><li><input type="text" class="textm" id="fontSize" value="字号" /><input type="hidden" id="fontSize2" value="16px" /><span class="btn" id="fontSize1"></span></li><li class="select"><p class="fon_12">12px</p><p class="fon_14">14px</p><p class="fon_16">16px</p><p class="fon_18">18px</p><p class="fon_20">20px</p><p class="fon_24">24px</p><p class="fon_30">30px</p></li></ul>');
    document.writeln('<ul><li><input type="text" class="textm" id="fontColor" value="字色" /><input type="hidden" id="fontColor2" value="z_mo" /><span class="btn" id="fontColor1"></span></li><li class="select"><p class="z_hei">黑色</p><p class="z_red">红色</p><p class="z_lan">蓝色</p><p class="z_lv">绿色</p><p class="z_hui">灰色</p><p class="z_li">栗色</p><p class="z_wu">雾白</p><p class="z_zi">暗紫</p><p class="z_he">玫褐</p></li></ul>');
    document.writeln('<ul><li><input type="text" class="textm" id="fontFamily" value="字体" /><input type="hidden" id="fontFamily2" value="fam_song" /><span class="btn" id="fontFamily1"></span></li><li class="select"><p class="fam_song">宋体</p><p class="fam_hei">黑体</p><p class="fam_kai">楷体</p><p class="fam_qi">启体</p><p class="fam_ya">雅黑</p></li></ul><input type="button" class="ud_but2" onmousemove="this.className=\'ud_but22\'" onmouseout="this.className=\'ud_but2\'" value="保存" id="saveButton" /><input type="button" class="ud_but1" onmousemove="this.className=\'ud_but11\'" onmouseout="this.className=\'ud_but1\'"  value="恢复" id="recoveryButton" /></div>');
}
function readCookStyle() {
    if ($.cookie("screen") != null && $.cookie("screen") != "") {
        $("#screen").val($.cookie("screen"))
    } else {
        $("#screen").val("滚屏")
    }
    if ($.cookie("fontSize") != null && $.cookie("fontSize") != "") {
        $(".yd_text2").addClass($.cookie("fontSize"));
        size = $.cookie("fontSize").replace("fon_", "");
        size += "px";
        $("#fontSize").val(size);
        $("#fontSize2").val($.cookie("fontSize"))
    }
    if ($.cookie("background") != null && $.cookie("background") != "") {
        var b = "背景";
        if ($.cookie("background") == "bg_lan") {
            b = "淡蓝"
        }
        if ($.cookie("background") == "bg_huang") {
            b = "明黄"
        }
        if ($.cookie("background") == "bg_lv") {
            b = "淡绿"
        }
        if ($.cookie("background") == "bg_fen") {
            b = "红粉"
        }
        if ($.cookie("background") == "bg_bai") {
            b = "白色"
        }
        if ($.cookie("background") == "bg_hui") {
            b = "灰色"
        }
        if ($.cookie("background") == "bg_hei") {
            b = "漆黑"
        }
        if ($.cookie("background") == "bg_cao") {
            b = "草绿"
        }
        if ($.cookie("background") == "bg_cha") {
            b = "茶色"
        }
        if ($.cookie("background") == "bg_yin") {
            b = "银色"
        }
        if ($.cookie("background") == "bg_mi") {
            b = "米色"
        }
        $("#background2").val($.cookie("background"));
        $("#background").val(b);
        $("body").addClass($.cookie("background"));
        $(".ydleft").addClass($.cookie("background"));
        $(".yd_text2").addClass($.cookie("background"))
    }
    if ($.cookie("fontColor") != null && $.cookie("fontColor") != "") {
        var a = "字色";
        if ($.cookie("fontColor") == "z_hei") {
            a = "黑色"
        }
        if ($.cookie("fontColor") == "z_red") {
            a = "红色"
        }
        if ($.cookie("fontColor") == "z_lan") {
            a = "蓝色"
        }
        if ($.cookie("fontColor") == "z_lv") {
            a = "绿色"
        }
        if ($.cookie("fontColor") == "z_hui") {
            a = "灰色"
        }
        if ($.cookie("fontColor") == "z_li") {
            a = "栗色"
        }
        if ($.cookie("fontColor") == "z_wu") {
            a = "雾白"
        }
        if ($.cookie("fontColor") == "z_zi") {
            a = "暗紫"
        }
        if ($.cookie("fontColor") == "z_he") {
            a = "玫褐"
        }
        $("#fontColor2").val($.cookie("fontColor"));
        $("#fontColor").val(a);
        $(".yd_text2").addClass($.cookie("fontColor"))
    }
    if ($.cookie("fontFamily") != null && $.cookie("fontFamily") != "") {
        var c = "字体";
        if ($.cookie("fontFamily") == "fam_song") {
            c = "宋体"
        }
        if ($.cookie("fontFamily") == "fam_hei") {
            c = "黑体"
        }
        if ($.cookie("fontFamily") == "fam_kai") {
            c = "楷体"
        }
        if ($.cookie("fontFamily") == "fam_qi") {
            c = "启体"
        }
        if ($.cookie("fontFamily") == "fam_ya") {
            c = "雅黑"
        }
        $("#fontFamily2").val($.cookie("fontFamily"));
        $("#fontFamily").val(c);
        $(".yd_text2").addClass($.cookie("fontFamily"))
    }
}
var a = (function() {
    var d;
    var g;
    var f;
    function c() {
        g = setInterval(b, 40);
        try {
            if (document.selection) {
                document.selection.empty()
            } else {
                var h = document.getSelection();
                h.removeAllRanges()
            }
        } catch(j) {}
    }
    function b() {
        d = document.documentElement.scrollTop || document.body.scrollTop;
        if ($.cookie("screen") != null) {
            d = d + parseInt($.cookie("screen"))
        }
        window.scroll(0, d);
        f = document.documentElement.scrollTop || document.body.scrollTop;
        if (d != f) {
            e()
        }
    }
    function e() {
        clearInterval(g)
    }
    return {
        start: c,
        stop: e
    }
})();
jQuery(document).dblclick(a.start);
jQuery(document).mousedown(a.stop)
$(function(){
    $("#screen").click(function() {
        var b = $("#screen").parent().parent().children(".select");
        b.show()
    });
    $("#screen1").click(function() {
        var b = $("#screen").parent().parent().children(".select");
        b.show()
    });
    $("#screen").parent().parent().children(".select").children("p").each(function() {
        $(this).click(function() {
            $("#screen").val($(this).html());
            $("#screen").parent().parent().children(".select").hide();
            var b = $("#screen").val();
            $.cookie("screen", b, {
                path: "/",
                expires: date
            });
            a.start()
        })
    });
    $("#background").click(function() {
        var b = $("#background").parent().parent().children(".select");
        b.show()
    });
    $("#background1").click(function() {
        var b = $("#background1").parent().parent().children(".select");
        b.show()
    });
    $(".select").parent().each(function() {
        $(this).mouseover(function() {
            $(this).children(".select").show()
        })
    });
    $(".select").parent().each(function() {
        $(this).mouseout(function() {
            $(this).children(".select").hide()
        })
    });
    $("#background").parent().parent().children(".select").children("p").each(function() {
        $(this).click(function() {
            $("#background").val($(this).html());
            $("#background").parent().parent().children(".select").hide();
            $(".ydleft").removeClass($("#background2").val());
            $("body").removeClass($("#background2").val());
            $("body").attr("style", "");
            $(".ydleft").attr("style", "");
            $("#background2").val($(this).attr("class"));
            $(".ydleft").addClass($(this).attr("class"));
            $("body").addClass($(this).attr("class"))
        })
    });
    $("#fontSize").click(function() {
        var b = $("#fontSize").parent().parent().children(".select");
        b.show()
    });
    $("#fontSize1").click(function() {
        var b = $("#fontSize1").parent().parent().children(".select");
        b.show()
    });
    $("#fontSize").parent().parent().children(".select").children("p").each(function() {
        $(this).click(function() {
            $("#fontSize").val($(this).html());
            $("#fontSize").parent().parent().children(".select").hide();
            $(".yd_text2").removeClass($("#fontSize2").val());
            $("#fontSize2").val($(this).attr("class"));
            $(".yd_text2").addClass($(this).attr("class"))
        })
    });
    $("#fontFamily").click(function() {
        var b = $("#fontFamily").parent().parent().children(".select");
        b.show()
    });
    $("#fontFamily1").click(function() {
        var b = $("#fontFamily1").parent().parent().children(".select");
        b.show()
    });
    $("#fontFamily").parent().parent().children(".select").children("p").each(function() {
        $(this).click(function() {
            $("#fontFamily").val($(this).html());
            $("#fontFamily").parent().parent().children(".select").hide();
            $(".yd_text2").removeClass($("#fontFamily2").val());
            $("#fontFamily2").val($(this).attr("class"));
            $(".yd_text2").addClass($(this).attr("class"))
        })
    });
    $("#fontColor").click(function() {
        var b = $("#fontColor").parent().parent().children(".select");
        b.show()
    });
    $("#fontColor1").click(function() {
        var b = $("#fontColor1").parent().parent().children(".select");
        b.show()
    });
    $("#fontColor").parent().parent().children(".select").children("p").each(function() {
        $(this).click(function() {
            $("#fontColor").val($(this).html());
            $("#fontColor").parent().parent().children(".select").hide();
            $(".yd_text2").removeClass($("#fontColor2").val());
            $("#fontColor2").val($(this).attr("class"));
            $(".yd_text2").addClass($(this).attr("class"))
        })
    });
    $("#saveButton").click(function() {
        $.cookie("screen", $("#screen").val(), {
            path: "/",
            expires: date
        });
        $.cookie("background", $("#background2").val(), {
            path: "/",
            expires: date
        });
        $.cookie("fontSize", $("#fontSize2").val(), {
            path: "/",
            expires: date
        });
        $.cookie("fontColor", $("#fontColor2").val(), {
            path: "/",
            expires: date
        });
        $.cookie("fontFamily", $("#fontFamily2").val(), {
            path: "/",
            expires: date
        });
        alert("保存成功")
    });
    $("#recoveryButton").click(function() {
        $("body").removeClass($.cookie("background"));
        $("body").removeClass($("#background2").val());
        $(".ydleft").removeClass($("#background2").val());
        $(".ydleft").removeClass($.cookie("background"));
        $("body").attr("style", "background:#fff");
        $(".ydleft").attr("style", "background:#FFF");
        $(".yd_text2").removeClass($("#background2").val());
        $(".yd_text2").removeClass($("#fontSize2").val());
        $(".yd_text2").removeClass($.cookie("fontSize"));
        $(".yd_text2").removeClass($("#fontColor2").val());
        $(".yd_text2").removeClass($.cookie("fontColor"));
        $(".yd_text2").removeClass($("#fontFamily2").val());
        $(".yd_text2").removeClass($.cookie("fontFamily"));
        $.cookie("background", "", {
            path: "/",
            expires: date
        });
        $.cookie("fontSize", "", {
            path: "/",
            expires: date
        });
        $.cookie("fontColor", "", {
            path: "/",
            expires: date
        });
        $.cookie("fontFamily", "", {
            path: "/",
            expires: date
        });
        $("#screen").val("滚屏");
        $("#background").val("背景");
        $("#fontColor").val("字色");
        $("#fontFamily").val("字体");
        $("#fontSize").val("字号")
    });
    readCookStyle();
});