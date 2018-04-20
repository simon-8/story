@extends('layout.admin')

@section('content')

    <div class="ibox float-e-margins">

        <form method="post" class="form-horizontal" action="{{ isset($id) ? route('Menu.postUpdate') : route('Menu.postCreate') }}" id="sform">
            {!! csrf_field() !!}
            <div class="col-sm-12 col-md-12">
                <div class="ibox-title">
                    @if(isset($id))
                        <h5>编辑菜单</h5>
                        <input type="hidden" name="id" value="{{ $id }}">
                    @else
                        <h5>添加菜单</h5>
                    @endif
                </div>
                <div class="ibox-content">

                    <div class="form-group">
                        <label class="col-sm-2 control-label">菜单名</label>
                        <div class="col-sm-10">
                            <input id="username" type="text" class="form-control" name="username" value="{{ isset($username) ? $username : old('username') }}">
                            <span class="help-block m-b-none">用户用来登录的账户名称</span>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">密码</label>
                        <div class="col-sm-10">
                            <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}">
                            <span class="help-block m-b-none">仅支持数字和字母的组合</span>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">真实姓名</label>
                        <div class="col-sm-10">
                            <input id="truename" type="text" class="form-control" name="truename" value="{{ isset($truename) ? $truename : old('truename') }}">
                            <span class="help-block m-b-none">用于登录后显示的昵称</span>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">邮箱</label>
                        <div class="col-sm-10">
                            <input id="email" type="text" class="form-control" name="email" value="{{ isset($email) ? $email : old('email') }}">
                            <span class="help-block m-b-none">便于邮件推送系统消息</span>
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
                            <a class="btn btn-white" href="{{ route('Manager.getIndex') }}">返回</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- jQuery Validation plugin javascript-->
    {!! jquery_validate_js() !!}
    <script>

        $(function(){
            {!! jquery_validate_default() !!}

            @if(isset($id))

            $("#sform").validate({
                debug:false,
                rules:{
                    username:{
                        required:true,
                        minlength:4,
                    },
                    /*                password:{
                     required:true,
                     minlength:4,
                     },*/
                    email:{
                        required:true,
                        email:true,
                    },
                    truename:{
                        required:true,
                        minlength:2,
                    },
                }
            });

            @else

            $("#sform").validate({
                debug:false,
                rules:{
                    username:{
                        required:true,
                        minlength:4,
                    },
                    password:{
                        required:true,
                        minlength:4,
                    },
                    email:{
                        required:true,
                        email:true,
                    },
                    truename:{
                        required:true,
                        minlength:2,
                    },
                }
            });

            @endif
        });
    </script>
@endsection('content')