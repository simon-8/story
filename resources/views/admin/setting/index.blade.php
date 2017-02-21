@extends('layout.admin')

@section('content')

    <div class="ibox-content clear">
        <form method="post" action="{{ route('Setting.postIndex') }}" class="form-horizontal">
            {{ csrf_field() }}
            <div class="col-sm-12 col-md-12 col-lg-12">
            @if(count($lists))
                @foreach($lists as $k => $v)
                <div class="form-group">
                    <div class="col-sm-1">
                        <label class="control-label">
                            {{--<input type="hidden" name="data[{{ $v['item'] }}][name]" value="{{ $v['name'] }}">--}}
                            {{--<input type="hidden" name="data[{{ $v['item'] }}][item]" value="{{ $v['name'] }}">--}}
                            {{ $v['name'] }}
                        </label>
                    </div>

                    <div class="col-sm-11 input-group">
                        <input type="text" class="form-control" name="data[{{ $v['item'] }}][value]" value="{{ $v['value'] }}">
                        <div class="input-group-btn">
                            <button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button">操作 <span class="caret"></span></button>
                            <ul class="dropdown-menu pull-right">
                                <li><a onclick="Edit({{ $k }})" id="edit_{{ $k }}" data="{{ json_encode($v) }}">编辑</a></li>
                                <li><a onclick="Delete('{{ $v['item'] }}')">删除</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                @endforeach
            @endif
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

</script>

{{--delete--}}
@include('admin.modal.delete' , ['formurl' => route('Setting.getDelete')])

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

{{--update--}}
<div class="modal inmodal" id="updateModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInX">
            <form action="{{ route('Setting.postCreate') }}" method="POST" class="form-horizontal">
                {!! csrf_field() !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">修改设置</h4>
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