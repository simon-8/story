@extends('layout.admin')

@section('content')
<table class="table table-bordered table-hover bg-white">
    <tr>
        <td width="50">编号</td>
        <td>上级菜单</td>
        <td>菜单名称</td>
        <td>控制器</td>
        <td>方法名</td>
        <td>图标</td>
        <td width="120">操作</td>
    </tr>
    <tr>
        <td>100</td>
        <td>系统设置</td>
        <td>wifi设置</td>
        <td>Wifi</td>
        <td>index</td>
        <td></td>
        <td>
            <button class="btn btn-sm btn-info">编辑</button>
            <button class="btn btn-sm btn-danger" onclick="Delete(1)">删除</button>
        </td>
    </tr>
    <tr>
        <td>100</td>
        <td>系统设置</td>
        <td>wifi设置</td>
        <td>Wifi</td>
        <td>index</td>
        <td></td>
        <td>
            <button class="btn btn-sm btn-info">编辑</button>
            <button class="btn btn-sm btn-danger" onclick="Delete(1)">删除</button>
        </td>
    </tr>
</table>

<script>

    var deleteModal = '#deleteModal';
    function Delete(id)
    {
        $(deleteModal).find('input[type=hidden]').val(id);
        $(deleteModal).modal('show');
    }

</script>

{{--delete--}}
@include('admin.modal.delete' , ['formurl' => route('Menu.getDelete')])

{{--update--}}
<div class="modal inmodal" id="updateModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInX">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">编辑菜单</h4>
                <small class="font-bold text-danger">删了可就没有了我跟你讲，不要搞事情。</small>
            </div>
            <div class="modal-body">
                <form action="{{ route('Menu.postUpdate') }}" method="post" class="form-horizontal">

                    <div class="form-group">
                        <label class="col-sm-2 control-label">用户名</label>
                        <div class="col-sm-10">
                            <input id="username" type="text" class="form-control" name="username" value="{{ isset($username) ? $username : old('username') }}">
                            <span class="help-block m-b-none">用户用来登录的账户名称</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">用户名</label>
                        <div class="col-sm-10">
                            <input id="username" type="text" class="form-control" name="username" value="{{ isset($username) ? $username : old('username') }}">
                            <span class="help-block m-b-none">用户用来登录的账户名称</span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <form action="{{ route('Manager.getDelete') }}">
                    <input type="hidden" name="id" value="0">
                    <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
                    <button type="submit" class="btn btn-primary">确定</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection('content')