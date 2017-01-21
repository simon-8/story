@extends('layout.admin')
@section('content')
<div class="row">

    <table class="table table-bordered table-hover bg-white">
        <tr>
            <td width="30"><input type="checkbox" name="" id="" class="i-checks"></td>
            <td width="50">编号</td>
            <td>用户名</td>
            <td>昵称</td>
            <td>邮箱</td>
            <td>创建时间</td>
            <td>最后一次登录时间</td>
            <td>最后一次登录IP</td>
            <td width="120">操作</td>
        </tr>
        @if(count($lists))
            @foreach($lists as $k=>$v)
                <tr>
                    <td width="30"><input type="checkbox" name="" id="" class="i-checks"></td>
                    <td>{{ $v->id }}</td>
                    <td>{{ $v->username }}</td>
                    <td>{{ $v->truename }}</td>
                    <td>{{ $v->email }}</td>
                    <td>{{ $v->created_at }}</td>
                    <td>{{ $v->lasttime > 0 ? date('Y-m-d H:i:s' , $v->lasttime) : '从未登录' }}</td>
                    <td>{{ $v->lastip ? $v->lastip : '从未登录' }}</td>
                    <td>
                        <a class="btn btn-sm btn-info" href="{{ url('admin/manager/update' , ['id'=>$v->id]) }}">编辑</a>
                        <a class="btn btn-sm btn-danger" onclick="Delete({{ $v->id }})">删除</a>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="8">
                    暂无数据
                </td>
            </tr>
        @endif
    </table>
    <a href="{{ route('Manager.getCreate') }}" class="btn btn-info">添加管理员</a>
    <a href="{{ route('Manager.getDelete') }}" class="btn btn-warning">批量删除</a>
    <a class="btn btn-warning">权限管理</a>
    <a class="btn btn-success">模块配置</a>
</div>

<script>

var deleteModal = '#deleteModal';
function Delete(id , name)
{
    name = name ? name : 'id';
    $(deleteModal).find('input[name='+name+']').val(id);
    $(deleteModal).modal('show');
}

</script>

@include('admin.modal.delete' , ['formurl' => route('Manager.getDelete')])
@endsection('content')