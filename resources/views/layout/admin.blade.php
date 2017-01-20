<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>后台主页</title>

    <meta name="keywords" content="">
    <meta name="description" content="">

    <!--[if lt IE 8]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->

    <link rel="shortcut icon" href="/favicon.ico">
    <link href="/skin/manager/css/bootstrap.min.css?v=3.3.5" rel="stylesheet">
    <link href="/skin/manager/css/font-awesome.min.css?v=4.4.0" rel="stylesheet">
    <link href="/skin/manager/css/animate.min.css" rel="stylesheet">
    <link href="/skin/manager/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="/skin/manager/css/style.min.css?v=4.0.0" rel="stylesheet">
    <script src="/skin/js/jquery.min.js?v=2.1.4"></script>
    <script src="/skin/js/bootstrap.min.js?v=3.3.5"></script>
    <script src="/skin/js/plugins/metisMenu/jquery.metisMenu.js"></script>
</head>

<body class="fixed-sidebar full-height-layout gray-bg mini-navbar" style="overflow:hidden">
<div id="wrapper">
    <!--左侧导航开始-->
@include('admin.menus')
<!--左侧导航结束-->
    <!--右侧部分开始-->
    <div class="gray-bg dashbard-1" id="page-wrapper" style="clear:both;overflow: auto;overflow-x:hidden">
        @include('admin.right_top')
        <div class="row content-tabs">
            <button class="roll-nav roll-left J_tabLeft"><i class="fa fa-backward"></i>
            </button>
            <nav class="page-tabs J_menuTabs">
                <div class="page-tabs-content">
                    <a href="javascript:;" class="active J_menuTab" data-id="index_v1.html">首页</a>
                </div>
            </nav>
            <button class="roll-nav roll-right J_tabRight"><i class="fa fa-forward"></i></button>
            <button class="roll-nav roll-right dropdown J_tabClose"><span class="dropdown-toggle" data-toggle="dropdown">关闭操作<span class="caret"></span></span>
                <ul role="menu" class="dropdown-menu dropdown-menu-right">
                    <li class="J_tabShowActive"><a>定位当前选项卡</a></li>
                    <li class="divider"></li>
                    <li class="J_tabCloseAll"><a>关闭全部选项卡</a></li>
                    <li class="J_tabCloseOther"><a>关闭其他选项卡</a></li>
                </ul>
            </button>
            <a href="{{ route('getAdminLogout') }}" class="roll-nav roll-right J_tabExit"><i class="fa fa fa-sign-out"></i> 退出</a>
        </div>
        <div class="row J_mainContent" id="content-main">
            <div class="wrapper wrapper-content">
                @if(session('Message'))
                    <div class="alert alert-success alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        {{ session('Message') }}
                    </div>
                @endif
                @if(count($errors) > 0)
                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            {{  $error }}
                        </div>
                    @endforeach
                @endif
                @yield('content')
            </div>
        </div>
        <div class="footer" style="clear:both;overflow: auto;overflow-x:hidden">
            <div class="pull-right">&copy; {{ date('Y')-1 }}-{{ date('Y')+1 }} <a href="/" target="_blank">Simon's blog</a></div>
        </div>
    </div>
    <!--右侧部分结束-->
    <!--右侧边栏开始-->
@include('admin.right_side')
<!--右侧边栏结束-->
    <!--mini聊天窗口开始-->
{{--@include('admin.mini_chat')--}}
<!--mini聊天窗口结束-->
</div>



{{--<script src="/skin/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>--}}
{{--<script src="/skin/js/plugins/layer/layer.min.js"></script>--}}
<script src="/skin/js/plugins/iCheck/icheck.min.js"></script>
<script src="/skin/js/manager.min.js?v=4.0.0"></script>

{{--<script type="text/javascript" src="/skin/js/contabs.min.js"></script>--}}
{{--<script src="/skin/js/plugins/pace/pace.min.js"></script>--}}


</body>

</html>