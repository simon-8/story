@extends('layout.admin')
@section('content')
    @if(1== 2 && PHP_OS != 'WINNT')
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>资源使用率</h5>
                </div>

                <div class="ibox-content">
                    <ul class="stat-list">
                        <li>
                            <h2 class="no-margins" id="cpuTotal">1.0Ghz</h2>
                            <small>CPU使用率</small>
                            <div class="stat-percent" id="cpuPercentText" >0%</div>
                            <div class="progress progress-mini">
                                <div id="cpuPercent" style="width: 0%;" class="progress-bar"></div>
                            </div>
                        </li>
                        <li>
                            <h2 class="no-margins " id="memTotal">2048MB</h2>
                            <small>内存使用率</small>
                            <div class="stat-percent" id="memRealPercentText">0%</div>
                            <div class="progress progress-mini">
                                <div id="memRealPercent" style="width: 0%;" class="progress-bar"></div>
                            </div>
                        </li>
                        <li>
                            <h2 class="no-margins " id="hdTotal">500G</h2>
                            <small>硬盘使用率</small>
                            <div class="stat-percent" id="hdPercentText">0%</div>
                            <div class="progress progress-mini">
                                <div id="hdPercent" style="width: 0%;" class="progress-bar"></div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-success pull-right">今天</span>
                    <h5>新增文档</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ $counts['bookDailyInsert'] }}</h1>
                    <div class="stat-percent font-bold text-success">
                        {{ $counts['bookDailyInsert'] ? round($counts['bookDailyInsert'] / $counts['bookTotalCount']) : 0 }}%
                        <i class="fa fa-level-up"></i>
                    </div>
                    <small>总文档</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-info pull-right">今天</span>
                    <h5>更新文档</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ $counts['bookDailyUpdate'] }}</h1>
                    <div class="stat-percent font-bold text-info">
                        {{ $counts['bookDailyUpdate'] ? round($counts['bookDailyUpdate'] / $counts['bookTotalCount']) : 0 }}%
                        <i class="fa fa-level-up"></i>
                    </div>
                    <small>总文档</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-primary pull-right">今天</span>
                    <h5>新增章节</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ $counts['chapterDailyCount'] }}</h1>
                    <div class="stat-percent font-bold text-navy">
                        {{ $counts['chapterInsertPrecent'] }}%
                        <i class="fa fa-level-up"></i>
                    </div>
                    <small>总章节</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-danger pull-right">总计</span>
                    <h5>队列</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ $counts['jobCount'] }}</h1>
                    {{--<div class="stat-percent font-bold text-navy">--}}
                        {{--20 %--}}
                        {{--<i class="fa fa-level-up"></i>--}}
                    {{--</div>--}}
                    <small>总队列</small>
                </div>
            </div>
        </div>
    </div>
    {{--<div class="row">--}}
        {{--<div class="col-lg-12">--}}
            {{--<div class="ibox float-e-margins">--}}
                {{--<div class="ibox-title">--}}
                    {{--<h5>订单</h5>--}}
                    {{--<div class="pull-right">--}}
                        {{--<div class="btn-group">--}}
                            {{--<button type="button" class="btn btn-xs btn-white active">天</button>--}}
                            {{--<button type="button" class="btn btn-xs btn-white">月</button>--}}
                            {{--<button type="button" class="btn btn-xs btn-white">年</button>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="ibox-content">--}}
                    {{--<div class="row">--}}
                        {{--<div class="col-lg-9">--}}
                            {{--<div class="flot-chart">--}}
                                {{--<div class="flot-chart-content" id="flot-dashboard-chart"></div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="col-lg-3">--}}
                            {{--<ul class="stat-list">--}}
                                {{--<li>--}}
                                    {{--<h2 class="no-margins">2,346</h2>--}}
                                    {{--<small>订单总数</small>--}}
                                    {{--<div class="stat-percent">48% <i class="fa fa-level-up text-navy"></i>--}}
                                    {{--</div>--}}
                                    {{--<div class="progress progress-mini">--}}
                                        {{--<div style="width: 48%;" class="progress-bar"></div>--}}
                                    {{--</div>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<h2 class="no-margins ">4,422</h2>--}}
                                    {{--<small>最近一个月订单</small>--}}
                                    {{--<div class="stat-percent">60% <i class="fa fa-level-down text-navy"></i>--}}
                                    {{--</div>--}}
                                    {{--<div class="progress progress-mini">--}}
                                        {{--<div style="width: 60%;" class="progress-bar"></div>--}}
                                    {{--</div>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<h2 class="no-margins ">9,180</h2>--}}
                                    {{--<small>最近一个月销售额</small>--}}
                                    {{--<div class="stat-percent">22% <i class="fa fa-bolt text-navy"></i>--}}
                                    {{--</div>--}}
                                    {{--<div class="progress progress-mini">--}}
                                        {{--<div style="width: 22%;" class="progress-bar"></div>--}}
                                    {{--</div>--}}
                                {{--</li>--}}
                            {{--</ul>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}

            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}

    <div class="row">

        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>消息</h5>
                </div>
                <div class="ibox-content ibox-heading">
                    <h3><i class="fa fa-envelope-o"></i> 新消息</h3>
                    <small><i class="fa fa-tim"></i> 您有22条未读消息</small>
                </div>
                <div class="ibox-content">
                    <div class="feed-activity-list">

                        <div class="feed-element">
                            <div>
                                <small class="pull-right text-navy">1月前</small>
                                <strong>井幽幽</strong>
                                <div>有人说：“一辈子很长，要跟一个有趣的人在一起”。我想关注我的人，应该是那种喜欢找乐子也乐意分享乐趣的人，你们一定挺优秀的。所以单身的应该在这条留言，互相勾搭一下。特别有钱人又帅可以直接私信我！</div>
                                <small class="text-muted">4月11日 00:00</small>
                            </div>
                        </div>

                        <div class="feed-element">
                            <div>
                                <small class="pull-right">2月前</small>
                                <strong>马伯庸 </strong>
                                <div>又方便，又防水，手感又好，还可以用手机遥控。简直是拍戏利器，由其是跟老师们搭戏的时候…想想还有点小激动啊，嘿嘿。</div>
                                <small class="text-muted">11月8日 20:08 </small>
                            </div>
                        </div>

                        <div class="feed-element">
                            <div>
                                <small class="pull-right">5月前</small>
                                <strong>芒果宓 </strong>
                                <div>一个完整的梦。</div>
                                <small class="text-muted">11月8日 20:08 </small>
                            </div>
                        </div>

                        <div class="feed-element">
                            <div>
                                <small class="pull-right">5月前</small>
                                <strong>刺猬尼克索</strong>
                                <div>哈哈哈哈 你卖什么萌啊! 蠢死了</div>
                                <small class="text-muted">11月8日 20:08 </small>
                            </div>
                        </div>


                        <div class="feed-element">
                            <div>
                                <small class="pull-right">5月前</small>
                                <strong>老刀99</strong>
                                <div>昨天评论里你见过最“温暖和感人”的诗句，整理其中经典100首，值得你收下学习。</div>
                                <small class="text-muted">11月8日 20:08 </small>
                            </div>
                        </div>
                        <div class="feed-element">
                            <div>
                                <small class="pull-right">5月前</small>
                                <strong>娱乐小主 </strong>
                                <div>你是否想过记录自己的梦？你是否想过有自己的一个记梦本？小时候写日记，没得写了就写昨晚的梦，后来变成了习惯………翻了一晚上自己做过的梦，想哭，想笑…</div>
                                <small class="text-muted">11月8日 20:08 </small>
                            </div>
                        </div>
                        <div class="feed-element">
                            <div>
                                <small class="pull-right">5月前</small>
                                <strong>DMG电影 </strong>
                                <div>《和外国男票乘地铁，被中国大妈骂不要脸》妹子实在委屈到不行，中国妹子找外国男友很令人不能接受吗？大家都来说说自己的看法</div>
                                <small class="text-muted">11月8日 20:08 </small>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>用户项目列表</h5>
                </div>
                <div class="ibox-content">
                    <table class="table table-hover no-margins">
                        <thead>
                        <tr>
                            <th>状态</th>
                            <th>日期</th>
                            <th>用户</th>
                            <th>值</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><small>进行中...</small>
                            </td>
                            <td><i class="fa fa-clock-o"></i> 11:20</td>
                            <td>青衣5858</td>
                            <td class="text-navy"> <i class="fa fa-level-up"></i> 24%</td>
                        </tr>
                        <tr>
                            <td><span class="label label-warning">已取消</span>
                            </td>
                            <td><i class="fa fa-clock-o"></i> 10:40</td>
                            <td>徐子崴</td>
                            <td class="text-navy"> <i class="fa fa-level-up"></i> 66%</td>
                        </tr>
                        <tr>
                            <td><small>进行中...</small>
                            </td>
                            <td><i class="fa fa-clock-o"></i> 01:30</td>
                            <td>姜岚昕</td>
                            <td class="text-navy"> <i class="fa fa-level-up"></i> 54%</td>
                        </tr>
                        <tr>
                            <td><small>进行中...</small>
                            </td>
                            <td><i class="fa fa-clock-o"></i> 02:20</td>
                            <td>武汉大兵哥</td>
                            <td class="text-navy"> <i class="fa fa-level-up"></i> 12%</td>
                        </tr>
                        <tr>
                            <td><small>进行中...</small>
                            </td>
                            <td><i class="fa fa-clock-o"></i> 09:40</td>
                            <td>荆莹儿</td>
                            <td class="text-navy"> <i class="fa fa-level-up"></i> 22%</td>
                        </tr>
                        <tr>
                            <td><span class="label label-primary">已完成</span>
                            </td>
                            <td><i class="fa fa-clock-o"></i> 04:10</td>
                            <td>栾某某</td>
                            <td class="text-navy"> <i class="fa fa-level-up"></i> 66%</td>
                        </tr>
                        <tr>
                            <td><small>进行中...</small>
                            </td>
                            <td><i class="fa fa-clock-o"></i> 12:08</td>
                            <td>范范范二妮</td>
                            <td class="text-navy"> <i class="fa fa-level-up"></i> 23%</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>工作环境</h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tbody>
                            @foreach ($envs as $env)
                                <tr>
                                    <td width="120px">{{ $env['name'] }}</td>
                                    <td>{{ $env['value'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

<!-- Flot -->
<script src="/skin/js/plugins/flot/jquery.flot.js"></script>
<script src="/skin/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
<script src="/skin/js/plugins/flot/jquery.flot.spline.js"></script>
<script src="/skin/js/plugins/flot/jquery.flot.resize.js"></script>
<script src="/skin/js/plugins/flot/jquery.flot.pie.js"></script>
<script src="/skin/js/plugins/flot/jquery.flot.symbol.js"></script>

<!-- Peity -->
<script src="/skin/js/plugins/peity/jquery.peity.min.js"></script>
<script src="/skin/js/demo/peity-demo.min.js"></script>

<!-- 自定义js -->
<script src="/skin/js/content.min.js?v=1.0.0"></script>


<!-- jQuery UI -->
<script src="/skin/js/plugins/jquery-ui/jquery-ui.min.js"></script>



<!-- EayPIE -->
<script src="/skin/js/plugins/easypiechart/jquery.easypiechart.js"></script>

<!-- Sparkline -->
<script src="/skin/js/plugins/sparkline/jquery.sparkline.min.js"></script>

<!-- Sparkline demo data  -->
<script src="/skin/js/demo/sparkline-demo.min.js"></script>

<script>
    $(document).ready(function() {

        @if(1== 2 && PHP_OS != 'WINNT')

        setInterval(function(){
            $.ajax({
                url:'?',
                type:'post',
                data:{},
                dataType:'json',
                success:function(res){
                    $.UpdateSysInfo(res);
                }
            })
        },3000);

        $.UpdateSysInfo = function(res)
        {
            $('#cpuTotal').html((res.cpu.mhz/1000).toFixed(2) + 'Ghz');
            $('#memTotal').html(res.memTotal);
            $('#hdTotal').html(res.hdTotal);

            $('#cpuPercent').css('width',res.cpuPercent + '%');
            $('#cpuPercentText').html(res.cpuPercent + '%');
            $('#memRealPercent').css('width',res.memRealPercent + '%');
            $('#memRealPercentText').html(res.memRealPercent + '%');
            $('#hdPercent').css('width',res.hdPercent + '%');
            $('#hdPercentText').html(res.hdPercent + '%');
        }
        @endif

        $(".chart").easyPieChart({
            barColor: "#f8ac59",
            scaleLength: 5,
            lineWidth: 4,
            size: 80
        });
        $(".chart2").easyPieChart({
            barColor: "#1c84c6",
            scaleLength: 5,
            lineWidth: 4,
            size: 80
        });
        var h = [[c(2012, 1, 1), 7], [c(2012, 1, 2), 6], [c(2012, 1, 3), 4], [c(2012, 1, 4), 8], [c(2012, 1, 5), 9], [c(2012, 1, 6), 7], [c(2012, 1, 7), 5], [c(2012, 1, 8), 4], [c(2012, 1, 9), 7], [c(2012, 1, 10), 8], [c(2012, 1, 11), 9], [c(2012, 1, 12), 6], [c(2012, 1, 13), 4], [c(2012, 1, 14), 5], [c(2012, 1, 15), 11], [c(2012, 1, 16), 8], [c(2012, 1, 17), 8], [c(2012, 1, 18), 11], [c(2012, 1, 19), 11], [c(2012, 1, 20), 6], [c(2012, 1, 21), 6], [c(2012, 1, 22), 8], [c(2012, 1, 23), 11], [c(2012, 1, 24), 13], [c(2012, 1, 25), 7], [c(2012, 1, 26), 9], [c(2012, 1, 27), 9], [c(2012, 1, 28), 8], [c(2012, 1, 29), 5], [c(2012, 1, 30), 8], [c(2012, 1, 31), 25]];
        var g = [[c(2012, 1, 1), 800], [c(2012, 1, 2), 500], [c(2012, 1, 3), 600], [c(2012, 1, 4), 700], [c(2012, 1, 5), 500], [c(2012, 1, 6), 456], [c(2012, 1, 7), 800], [c(2012, 1, 8), 589], [c(2012, 1, 9), 467], [c(2012, 1, 10), 876], [c(2012, 1, 11), 689], [c(2012, 1, 12), 700], [c(2012, 1, 13), 500], [c(2012, 1, 14), 600], [c(2012, 1, 15), 700], [c(2012, 1, 16), 786], [c(2012, 1, 17), 345], [c(2012, 1, 18), 888], [c(2012, 1, 19), 888], [c(2012, 1, 20), 888], [c(2012, 1, 21), 987], [c(2012, 1, 22), 444], [c(2012, 1, 23), 999], [c(2012, 1, 24), 567], [c(2012, 1, 25), 786], [c(2012, 1, 26), 666], [c(2012, 1, 27), 888], [c(2012, 1, 28), 900], [c(2012, 1, 29), 178], [c(2012, 1, 30), 555], [c(2012, 1, 31), 993]];
        var e = [{
            label: "订单数",
            data: g,
            color: "#1ab394",
            bars: {
                show: true,
                align: "center",
                barWidth: 24 * 60 * 60 * 600,
                lineWidth: 0
            }
        },
            {
                label: "付款数",
                data: h,
                yaxis: 2,
                color: "#464f88",
                lines: {
                    lineWidth: 1,
                    show: true,
                    fill: true,
                    fillColor: {
                        colors: [{
                            opacity: 0.2
                        },
                            {
                                opacity: 0.2
                            }]
                    }
                },
                splines: {
                    show: false,
                    tension: 0.6,
                    lineWidth: 1,
                    fill: 0.1
                },
            }];
        var a = {
            xaxis: {
                mode: "time",
                tickSize: [3, "day"],
                tickLength: 0,
                axisLabel: "Date",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: "Arial",
                axisLabelPadding: 10,
                color: "#838383"
            },
            yaxes: [{
                position: "left",
                max: 1070,
                color: "#838383",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: "Arial",
                axisLabelPadding: 3
            },
                {
                    position: "right",
                    clolor: "#838383",
                    axisLabelUseCanvas: true,
                    axisLabelFontSizePixels: 12,
                    axisLabelFontFamily: " Arial",
                    axisLabelPadding: 67
                }],
            legend: {
                noColumns: 1,
                labelBoxBorderColor: "#000000",
                position: "nw"
            },
            grid: {
                hoverable: false,
                borderWidth: 0,
                color: "#838383"
            }
        };
        function c(j, k, i) {
            return new Date(j, k - 1, i).getTime()
        }
        var b = null,
                d = null;
        //$.plot($("#flot-dashboard-chart"), e, a);
        //var f = {
        //    "US": 298,
        //    "SA": 200,
        //    "DE": 220,
        //    "FR": 540,
        //    "CN": 120,
        //    "AU": 760,
        //    "BR": 550,
        //    "IN": 200,
        //    "GB": 120,
        //};

    });
</script>
@endsection('content')