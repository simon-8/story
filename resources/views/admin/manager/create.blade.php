@extends('layout.admin')

@section('content')

<div class="ibox float-e-margins">
    <form method="post" class="form-horizontal" action="{{ route('Manager.postCreate') }}" id="sform">
        {!! csrf_field() !!}
        <div class="col-sm-12 col-md-6">
            <div class="ibox-title">
                <h5>添加用户</h5>
            </div>
            <div class="ibox-content">

                    <div class="form-group">
                        <label class="col-sm-2 control-label">用户名</label>
                        <div class="col-sm-10">
                            <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" minlength="4" required>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">密码</label>
                        <div class="col-sm-10">
                            <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}" minlength="4" required>
                            <span class="help-block m-b-none">仅支持数字和字母的组合</span>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">真实姓名</label>
                        <div class="col-sm-10">
                            <input id="truename" type="text" class="form-control" name="truename" value="{{ old('truename') }}" minlength="2" required>
                            <span class="help-block m-b-none">用于登录后显示</span>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">邮箱</label>
                        <div class="col-sm-10">
                            <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" minlength="6" required>
                            <span class="help-block m-b-none" email:true>便于邮件推送消息</span>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">是否管理员</label>
                        <div class="col-sm-10">
                            <div class="checkbox">
                                <label class="i-checks"><input id="is_admin" type="checkbox" class="i-checks">自动登录</label>

                                <label>
                                    <input type="checkbox" class="i-checks" name="groupid" value="1">是
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">权限管理</label>
                        <div class="col-sm-10">
                            <div class="checkbox">
                                <label>

                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button class="btn btn-primary" type="submit">保存内容</button>
                            <a class="btn btn-white" href="">取消</a>
                        </div>
                    </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="ibox-title">
                <h5>其他设置</h5>
            </div>
            <div class="ibox-content">
                <div class="form-group">
                    <label class="col-sm-2 control-label">模块权限</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="" value="">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">功能细分</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="" value="">
                        <span class="help-block m-b-none">仅支持数字和字母的组合</span>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">权限管理</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="" value="">
                        <span class="help-block m-b-none">仅支持数字和字母的组合</span>
                    </div>
                </div>
                <div class="form-group"></div>
                <div class="hr-line-dashed"></div>
            </div>
        </div>
    </form>
</div>

<!-- jQuery Validation plugin javascript-->
<script src="/skin/js/plugins/validate/jquery.validate.min.js"></script>
<script src="/skin/js/plugins/validate/messages_zh.min.js"></script>
<script>

    $(function(){
        $.validator.setDefaults({
            highlight: function(a) {
                $(a).closest(".form-group").removeClass("has-success").addClass("has-error")
            },
            success: function(a) {
                a.closest(".form-group").removeClass("has-error").addClass("has-success")
            },
            errorElement: "span",
            errorPlacement: function(a, b) {
                if (b.is(":radio") || b.is(":checkbox")) {
                    a.appendTo(b.parent().parent().parent())
                } else {
                    a.appendTo(b.parent())
                }
            },
            errorClass: "help-block m-b-none",
            validClass: "help-block m-b-none"
        });
        $("#sform").validate({
            debug:true
        });
    });

/*    $().ready(function() {
        $("#commentForm").validate();
        var a = "<i class='fa fa-times-circle'></i> ";
        $("#signupForm").validate({
            rules: {
                firstname: "required",
                lastname: "required",
                username: {
                    required: true,
                    minlength: 2
                },
                password: {
                    required: true,
                    minlength: 5
                },
                confirm_password: {
                    required: true,
                    minlength: 5,
                    equalTo: "#password"
                },
                email: {
                    required: true,
                    email: true
                },
                topic: {
                    required: "#newsletter:checked",
                    minlength: 2
                },
                agree: "required"
            },
            messages: {
                firstname: a + "请输入你的姓",
                lastname: a + "请输入您的名字",
                username: {
                    required: a + "请输入您的用户名",
                    minlength: a + "用户名必须两个字符以上"
                },
                password: {
                    required: a + "请输入您的密码",
                    minlength: a + "密码必须5个字符以上"
                },
                confirm_password: {
                    required: a + "请再次输入密码",
                    minlength: a + "密码必须5个字符以上",
                    equalTo: a + "两次输入的密码不一致"
                },
                email: a + "请输入您的E-mail",
                agree: {
                    required: a + "必须同意协议后才能注册",
                    element: "#agree-error"
                }
            }
        });
        $("#username").focus(function() {
            var c = $("#firstname").val();
            var b = $("#lastname").val();
            if (c && b && !this.value) {
                this.value = c + "." + b
            }
        })*/
//    });
</script>
@endsection('content')