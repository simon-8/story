@extends('layout.admin')

@section('content')

    <div class="ibox-content clear">
        <form method="post" action="{{ route('Setting.postIndex') }}" class="form-horizontal">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label class="col-sm-3 control-label">网站标题</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="title" value="{$title}">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">网站关键词</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="keywords">{$keywords}</textarea>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">网站简介</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="description">{$description}</textarea>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">网站备案号</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="icp" value="{$icp}">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">网站版权</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="powerby" value="{$powerby}">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">管理员邮箱</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="admin_email" value="{$admin_email}">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">QQ登录APP ID</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="oauth_qq_appid" value="{$oauth_qq_appid}">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">QQ互联APP KEY</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="oauth_qq_appkey" value="{$oauth_qq_appkey}">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <button class="btn btn-primary" type="submit">保存</button>
                        <button class="btn btn-warning" type="button" onclick="location.href=''">取消</button>
                    </div>
                </div>
            </div>

        </form>
    </div>
@endsection