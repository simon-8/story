Zepto(function ($) {
    $.fn.cookie = function (name, value, options) {
        if (typeof value != 'undefined') { // name and value given, set cookie 
            options = options || {};
            if (value === null) {
                value = '';
                options.expires = -1;
            }
            var expires = '';
            if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
                var date;
                if (typeof options.expires == 'number') {
                    date = new Date();
                    date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
                } else {
                    date = options.expires;
                }
                expires = '; expires=' + date.toGMTString(); // use expires attribute, max-age is not supported by IE 
            }
            var path = options.path ? '; path=' + options.path : '';
            var domain = options.domain ? '; domain=' + options.domain : '';
            var secure = options.secure ? '; secure' : '';
            document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure, ';'].join('');
        } else { // only name given, get cookie 
            var cookieValue = null;
            if (document.cookie && document.cookie != '') {
                var cookies = document.cookie.split(';');
                for (var i = 0; i < cookies.length; i++) {
                    var cookie = $.trim(cookies[i]);
                    // Does this cookie string begin with the name we want? 
                    if (cookie.substring(0, name.length + 1) == (name + '=')) {
                        cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                        break;
                    }
                }
            }
            return cookieValue;
        }
    };
    
    var isNight = !!$.fn.cookie("night-mode");
    var chapterView = $("div.wrapper"), body = $("body");
    var pageContent = chapterView.find(".articlecon"), saveFont = $.fn.cookie("current-font"), currentFont = 1;
    var font = function () {
        //font size;
        var sizes = ["font-normal", "font-large", "font-xlarge", "font-xxlarge", "font-xxxlarge"],
            level = sizes.length;

        return {
            set: function (c) {
                pageContent.toggleClass(sizes[currentFont] + " " + sizes[c]);
                currentFont = c;
                $.fn.cookie("current-font", c, { expires: 3600, path: "/" });
                $.fn.cookie("currentFontString", sizes[c], { expires: 3600, path: "/" });
            },
            increase: function () {
                if (currentFont < level - 1) {
                    this.set(currentFont + 1);
                }
            },
            descrease: function () {
                if (currentFont > 0) {
                    this.set(currentFont - 1);
                }
            },
            day: function () {
                isNight = false;
                body.removeClass("nightbg").addClass("readbg");
                $.fn.cookie("night-mode", false, { expires: -1, path: "/" });
            },
            night: function () {
                isNight = true;
                body.removeClass("readbg").addClass("nightbg");
                $.fn.cookie("night-mode", true, { expires: 3600, path: "/" });
            }
        };
    }();
   
    if (typeof saveFont !== "undefined") {
        //console.log(saveFont);
        if (saveFont == null)
            saveFont = 1;
        font.set(saveFont * 1);
    }

    if (isNight) {
        font.night();
    }

    $("a.aadd").click(function () {
        font.increase();
    });

    $("a.aminus").click(function () {
        font.descrease();
    });

    $("a.pattern").click(function () {
        if (isNight) {
            font.day();
        } else {
            font.night();
        }
    });
});

$(document).bind("contextmenu", function (e) {
    return false;
});