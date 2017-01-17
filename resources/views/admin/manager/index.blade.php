@extends('layout.admin')
@section('content')
<div class="row">

    <table class="table table-bordered table-hover bg-white">
        <tr>
            <td><input type="checkbox" name="" id=""></td>
            <td>编号</td>
            <td>用户名</td>
            <td>昵称</td>
            <td>创建时间</td>
            <td>最后一次登录时间</td>
            <td>最后一次登录ip</td>
            <td>操作</td>
        </tr>
        @if(count($lists))
            @foreach($lists as $k=>$v)
                <tr>
                    <td><input type="checkbox" name="" id=""></td>
                    <td>{{ $v->id }}</td>
                    <td>{{ $v->username }}</td>
                    <td>{{ $v->truename }}</td>
                    <td>{{ $v->created_at }}</td>
                    <td>{{ date('Y-m-d H:i:s' , $v->lasttime) }}</td>
                    <td>{{ $v->lastip }}</td>
                    <td>
                        <a class="btn btn-sm btn-info" href="{{ route('') }}">编辑</a>
                        <a class="btn btn-sm btn-danger" href="{{ route('') }}">删除</a>
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
    <button class="btn">管理员列表</button>
    <button class="btn">权限管理</button>
    <button class="btn">配置</button>
</div>
@endsection('content')