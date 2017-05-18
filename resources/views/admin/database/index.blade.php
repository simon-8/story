@extends('layout.admin')

@section('content')
    <table class="table table-bordered table-hover bg-white text-center">
        <tr>
            <td>表名</td>
            <td>引擎</td>
            <td>编码格式</td>
            <td>总记录数</td>
            <td>已用空间</td>
            <td> 总空间 </td>
            <td>空间使用</td>
            <td>创建时间</td>
            <td>操 作</td>
        </tr>
        @if(count($lists) > 0)
            @foreach($lists as $v)
                <tr>
                    <td>{{ $v['Name'] }}</td>
                    <td>{{ $v['Engine'] }}</td>
                    <td>{{ $v['Collation'] }}</td>
                    <td>{{ $v['Rows'] }}</td>
                    <td>{{ $v['Data_length'] > 1073741824 ? round($v['Data_length']/1073741824 , 2).'GB' : round($v['Data_length']/1048576,2).'MB' }}</td>
                    <td>{{ $v['Max_data_length'] > 1099511627776 ? round($v['Max_data_length']/1099511627776 , 2).'TB' : round($v['Max_data_length']/1073741824,2).'GB' }}</td>
                    <td>
                        <div class="progress">
                            <div style="width: {{ ($v['Data_length'] == 0 || $v['Max_data_length'] == 0) ? 0 : ceil($v['Data_length']/$v['Max_data_length']) }}%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="35" role="progressbar" class="progress-bar progress-bar-success">
                                <span class="sr-only"></span>
                            </div>
                        </div>
                    </td>
                    <td>{{ $v['Create_time'] }}</td>
                    <td>
                        <button class="btn btn-info btn-sm" onclick="ShowFields('{{ $v['Name'] }}')">数据字典</button>
                        <button class="btn btn-info btn-sm" onclick="RepairTable('{{ $v['Name'] }}')">修复</button>
                        <button class="btn btn-info btn-sm" onclick="OptimizeTable('{{ $v['Name'] }}')">优化</button>
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

@endsection('content')
<script>
    var showModal = '#showModal';
    function ShowFields(table)
    {
        loading();
        $.get('{!! route('Database.getFields') !!}' , {'table' : table} , function(response){
            var tr = '';
            $('#tablename').text(table);
            $.each(response , function(k , v){
                tr += '<tr><td>' + v.Field +'</td>';
                tr += '<td>' + v.Type +'</td>';
                tr += '<td>' + (v.Key == 'PRI' ? 'YES' : 'NO') +'</td>';
                tr += '<td>' + v.Comment +'</td>';
                tr += '<td>' + v.Default +'</td></tr>';
            });
            $(showModal).find('tbody').html(tr);
            $(showModal).modal('show');
            loading(true);
        });
    }
    function RepairTable(table)
    {
        loading();
        $.get('{!! route('Database.getRepair') !!}' , {'table' : table} ,function(response){
            if(response)
            {
                layer.alert('修复成功',{icon:1});
            }
            else
            {
                layer.alert('修复失败',{icon:2});
            }
            loading(true);
        });
    }
    function OptimizeTable(table)
    {
        loading();
        $.get('{!! route('Database.getOptimize') !!}' , {'table' : table} ,function(response){
            if(response)
            {
                layer.alert('优化成功',{icon:1});
            }
            else
            {
                layer.alert('优化失败',{icon:2});
            }
            loading(true);
        });
    }
</script>
{{--show--}}
<div class="modal inmodal" id="showModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInX">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title"><b id="tablename"></b> 字段信息</h4>
                {{--<small class="font-bold text-danger">删了可就没有了我跟你讲，不要搞事情。</small>--}}
            </div>
            <div class="modal-body">

                <table class="table table-bordered table-hover bg-white text-center">
                    <thead>
                        <tr>
                            <td>字段名</td>
                            <td>类型</td>
                            <td>主键</td>
                            <td>注释</td>
                            <td>默认值</td>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>