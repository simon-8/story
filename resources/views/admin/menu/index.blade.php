@extends('layout.admin')

@section('content')
    <table class="table table-hover table-bordered">
        <tr>
            <td>编号</td>
            <td>上级菜单</td>
            <td>菜单名称</td>
            <td>控制器</td>
            <td>方法名</td>
            <td>图标</td>
            <td>操作</td>
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
                <button class="btn btn-sm btn-danger">删除</button>
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
                <button class="btn btn-sm btn-danger">删除</button>
            </td>
        </tr>
    </table>
@endsection('content')