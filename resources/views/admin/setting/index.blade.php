@extends('layout.admin')

@section('content')

    <div class="ibox-content clear">
        <form method="post" action="{{ route('Setting.postIndex') }}" class="form-horizontal">
            <div class="col-sm-12 col-md-12 col-lg-12">
            @if(count($lists))
                @foreach($lists as $v)
                <div class="form-group">
                    <label class="col-sm-2 control-label">{{ $v['name'] }}</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="{{ $v['item'] }}" value="{{ $v['value'] }}">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                @endforeach
            @endif
                <div class="form-group">
                    <label class="col-sm-2 control-label">网站关键词</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="keywords">{$keywords}</textarea>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">网站简介</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="description">{$description}</textarea>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">网站备案号</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="icp" value="{$icp}">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">网站版权</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="powerby" value="{$powerby}">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">管理员邮箱</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="admin_email" value="{$admin_email}">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">QQ登录APP ID</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="oauth_qq_appid" value="{$oauth_qq_appid}">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">QQ互联APP KEY</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="oauth_qq_appkey" value="{$oauth_qq_appkey}">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createModal">添加</button>
                        <button class="btn btn-primary" type="submit">保存</button>
                        <button class="btn btn-warning" type="button" onclick="location.href=''">取消</button>
                    </div>
                </div>
            </div>

        </form>
    </div>


{{--create--}}
<div class="modal inmodal" id="createModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInX">
            <form action="{{ route('Setting.postCreate') }}" method="POST" class="form-horizontal">
                {!! csrf_field() !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">添加设置</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">选项名</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="选项名">
                            <span class="help-block m-b-none">用来显示的名称</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">字段名</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="item" value="{{ old('item') }}" placeholder="字段名">
                            <span class="help-block m-b-none">数据库中存储的字段名称</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">选项值</label>
                        <div class="col-sm-10">
                            <input id="prefix" type="text" class="form-control" name="value" value="{{ old('value') }}" placeholder="选项值">
                            <span class="help-block m-b-none"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
                    <button type="submit" class="btn btn-primary">确定</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection