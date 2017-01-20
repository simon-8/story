<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">

    <title>后台 - 注册</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link href="/skin/manager/css/bootstrap.min.css?v=3.3.5" rel="stylesheet">
    <link href="/skin/manager/css/font-awesome.min.css?v=4.4.0" rel="stylesheet">
    <link href="/skin/manager/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="/skin/manager/css/animate.min.css" rel="stylesheet">
    <link href="/skin/manager/css/style.min.css?v=4.0.0" rel="stylesheet">
</head>

<body class="gray-bg">

<div class="middle-box text-center loginscreen   animated fadeInDown">
    <div>
        <div>

            <h1 class="logo-name">SC</h1>

        </div>
        <h3>欢迎注册</h3>
        <p>创建一个新账户</p>

        @if($errors)
            @foreach($errors->all() as $error)
                <p class="text-danger">
                    {{ $error }}
                </p>
            @endforeach
        @endif

        <form class="m-t" role="form" action="{{ route('postAdminRegister') }}" method="post">
            {!! csrf_field() !!}
            <div class="form-group">
                <input name="username" type="text" class="form-control" placeholder="请输入用户名" required="" value="{{ old('username') }}">
            </div>
            <div class="form-group">
                <input name="truename" type="text" class="form-control" placeholder="请输入真实姓名" required="" value="{{ old('truename') }}">
            </div>
            <div class="form-group">
                <input name="password" type="password" class="form-control" placeholder="请输入密码" required="">
            </div>
            <div class="form-group">
                <input name="password_confirm" type="password" class="form-control" placeholder="请再次输入密码" required="">
            </div>
            <div class="form-group text-left">
                <div class="checkbox i-checks">
                    <label class="no-padding">
                        <input type="checkbox"><i></i> 我同意注册协议</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary block full-width m-b">注 册</button>

            <p class="text-muted text-center"><small>已经有账户了？</small><a href="{{ route('getAdminLogin') }}">点此登录</a></p>

        </form>
    </div>
</div>

<!-- 全局js -->
<script src="/skin/js/jquery.min.js?v=2.1.4"></script>
<script src="/skin/js/bootstrap.min.js?v=3.4.0"></script>
<!-- iCheck -->
<script src="/skin/js/plugins/iCheck/icheck.min.js"></script>
<script>
    $(document).ready(function () {
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
    });
</script>

</body>
</html>