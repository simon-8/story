@extends('layout.admin')

@section('content')
    <table class="table table-bordered table-hover bg-white text-center">
        <tr>
            <td>队列驱动</td>
            <td>引擎</td>
            <td>编码格式</td>
            <td>总记录数</td>
            <td>空间使用</td>
            <td>创建时间</td>
            <td>操 作</td>
        </tr>
        <tr>

        </tr>
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