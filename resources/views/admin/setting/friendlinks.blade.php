@extends('layout.admin')

@section('content')
<table class="table table-bordered table-hover bg-white text-center">
    <tr>
        <td width="50">排序</td>
        <td width="50">编号</td>
        <td width="150" align="left">名称</td>
        <td>链接地址</td>
        <td>创建时间</td>
        <td>修改时间</td>
        <td width="180">操作</td>
    </tr>
    @if(count($lists) > 0)
        @foreach($lists as $v)
            <tr>
                <td>{{ $v['listorder'] }}</td>
                <td>{{ $v['id'] }}</td>
                <td align="left">{{ $v['title'] }}</td>
                <td>{{ $v['linkurl'] }}</td>
                <td>{{ $v['created_at'] }}</td>
                <td>{{ $v['updated_at'] }}</td>
                <td>
                    <button class="btn btn-sm btn-info" id="edit_{{ $v['id'] }}" data="{{ json_encode($v) }}" onclick="Edit({{ $v['id'] }})">编辑</button>
                    <button class="btn btn-sm btn-danger" onclick="Delete({{ $v['id'] }})">删除</button>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="7">
                未找到数据
            </td>
        </tr>
    @endif
</table>
<button class="btn btn-success" data-toggle="modal" data-target="#createModal">添加链接</button>
<script>

    var deleteModal = '#deleteModal';
    var updateModal = '#updateModal';
    var createModal = '#createModal';

    function Delete(id , name)
    {
        name = name ? name : 'id';
        $(deleteModal).find('input[name='+name+']').val(id);
        $(deleteModal).modal('show');
    }

    function Edit(id)
    {
        var json = $('#edit_' + id).attr('data');
        json = JSON.parse(json);
        $.each(json , function(k , v){
            $(updateModal).find('input[name=' + k + ']').val(v);
        });

        $(updateModal).modal('show');
    }
    function AddChild(id) {
        var json = $('#edit_' + id).attr('data');
        json = JSON.parse(json);
        $(createModal).find('select[name=pid]').val(json.id);
        $(createModal).find('input[name=prefix]').val(json.prefix);
        $(createModal).modal('show');
    }
</script>

{{--delete--}}
@include('admin.modal.delete' , ['formurl' => route('Setting.getFriendLinkDelete')])

{{--create--}}
<div class="modal inmodal" id="createModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInX">
            <form action="{{ route('Setting.getFriendLinks') }}" method="POST" class="form-horizontal">
                {!! csrf_field() !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">添加友链</h4>
                    {{--<small class="font-bold text-danger">删了可就没有了我跟你讲，不要搞事情。</small>--}}
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">名称</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="百度集团">
                            <span class="help-block m-b-none">用来显示的名称</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">链接地址</label>
                        <div class="col-sm-10">
                            <input id="prefix" type="text" class="form-control" name="linkurl" value="{{ old('linkurl') }}" placeholder="http://">
                            <span class="help-block m-b-none"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">排序</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="listorder" value="{{ old('listorder') ? old('listorder') : 0 }}" placeholder="0">
                            <span class="help-block m-b-none">越大越靠前</span>
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


{{--update--}}
<div class="modal inmodal" id="updateModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInX">
            <form action="{{ route('Setting.getFriendLinks') }}" method="POST" class="form-horizontal">
                {!! csrf_field() !!}
                <input type="hidden" name="id" value="">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">编辑友链</h4>
                    {{--<small class="font-bold text-danger">删了可就没有了我跟你讲，不要搞事情。</small>--}}
                </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">名称</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="title" value="" placeholder="百度集团">
                            <span class="help-block m-b-none">用来显示的名称</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">链接地址</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="linkurl" value="" placeholder="http://">
                            <span class="help-block m-b-none"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">排序</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="listorder" value="" placeholder="0">
                            <span class="help-block m-b-none">越大越靠前</span>
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
@endsection('content')