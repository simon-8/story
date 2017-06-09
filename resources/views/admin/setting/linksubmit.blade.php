@extends('layout.admin')

@section('content')
    <table class="table table-bordered table-hover bg-white text-center">
        <tr>
            <td>搜索引擎</td>
            <td>BookID</td>
            <td>DetailID</td>
            <td>更新时间</td>
            <td>操 作</td>
        </tr>
        @if(count($lists) > 0)
            @foreach($lists as $v)
                <tr>
                    <td>{{ $v['site'] }}</td>
                    <td>{{ $v['bookid'] }}</td>
                    <td>{{ $v['detailid'] }}</td>
                    <td>{{ $v['updated_at'] }}</td>
                    <td>
                        <button class="btn btn-info btn-sm" onclick="linkSubmit('{{ $v['site'] }}')">提交</button>
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
   function linkSubmit(site)
   {
       layer.prompt({
           title:'请输入要提交的网址数量',
           value: 1700,
           shadeClose:true,
       },function(value, index, elem){
           loading();
           var url = "{!! route('Setting.getLinkSubmit') !!}?site=" + site + "&number=" + value;
           location.href = url;
           layer.close(index);
       });
   }
</script>