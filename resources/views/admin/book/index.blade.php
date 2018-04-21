@extends('layout.admin')

@section('content')
<div class="alert alert-success alert-dismissable">
    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
    当前队列数量 <strong id="queueNumber">0</strong>
</div>
<table class="table table-bordered table-hover bg-white text-center">
    <tr>
        <td width="50"><input type="checkbox" id="checkall" class="i-checks "></td>
        <td width="50">编号</td>
        <td width="100">栏目</td>
        <td width="150" align="left">标题</td>
        <td width="50">图片</td>
        <td>最新</td>
        <td>作者</td>
        <td>字数</td>
        <td>关注人数</td>
        <td>浏览量</td>
        <td>添加时间</td>
        <td>更新时间</td>
        <td width="250">操作</td>
    </tr>
    @if(count($lists) > 0)
        @foreach($lists as $v)
            <tr id="book_{{ $v['id'] }}">
                <td><input type="checkbox" name="ids" value="{{ $v['id'] }}" class="i-checks"></td>
                <td>{{ $v['id'] }}</td>
                <td>{{ $categorys[$v['catid']]['name'] }}</td>
                <td align="left"><strong>{{ $v['title'] }}</strong></td>
                <td><i class="fa fa-file-image-o" onclick="preview('{!! bookimg($v['thumb']) !!}',210,280)"></i></td>
                <td>{{ $v['zhangjie'] }}</td>
                <td>{{ $v['author'] }}</td>
                <td>{{ $v['wordcount'] }}</td>
                <td>{{ $v['follow'] }}</td>
                <td>{{ $v['hits'] }}</td>
                <td>{{ $v['created_at'] }}</td>
                <td>{{ $v['updated_at'] }}</td>
                <td>
                    <button class="btn btn-sm btn-success" onclick="getChapters({{ $v['id'] }})">章节</button>
                    <button class="btn btn-sm btn-success" onclick="updateChapters({{ $v['id'] }})">更新</button>
                    <button class="btn btn-sm btn-info" id="edit_{{ $v['id'] }}" data="{{ json_encode($v) }}" onclick="Edit({{ $v['id'] }})">编辑</button>
                    <button class="btn btn-sm btn-danger" onclick="Delete({{ $v['id'] }})">删除</button>
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="13">
                {!! $lists->render() !!}
            </td>
        </tr>
    @else
        <tr>
            <td colspan="13">
                未找到数据
            </td>
        </tr>
    @endif
</table>
<button class="btn btn-success" data-toggle="modal" data-target="#createModal">添加采集队列</button>
{{--<button class="btn btn-success" onclick="getListsUpdate();">添加更新队列</button>--}}
<button class="btn btn-success" data-toggle="modal" data-target="#updateQueueModal">添加更新队列</button>
<script>

    var dlistsModal = '#DetailListsModal';
    var createModal = '#createModal';
    var updateModal = '#updateModal';
    var deleteModal = '#deleteModal';

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
            $(updateModal).find('[name=' + k + ']').val(v);
        });

        $(updateModal).modal('show');
    }

    //显示该章节内容
    function ShowDetail(pid, id){
        loading();
        $.get("{!! route('Book.chapterContent') !!}" , {pid: pid, id: id} ,function(res){
            layer.open({
                title:'详情',
                area:'800px',
                btn:false,
                shadeClose:true,
                content:res,
                success:function(){
                    loading(true);
                }
            });
        });
    }

    //编辑章节
    function UpdateDetail(id) {
        window.open("{!! route('Book.updateChapter') !!}?id=" + id);
    }

    //删除章节
    function DeleteDetail(id) {
        window.open("{!! route('Book.deleteChapter') !!}?id=" + id);
    }

    //数据填充至模态层
    function showData(id,res){
        if(res.data.length){
            var tr = '';
            $.each(res.data , function(k,v){
                tr += '<tr><td>' + v.id + '</td><td align="left"><strong>' + v.title + '</strong></td><td>' + v.created_at + '</td><td>' + v.updated_at + '</td> <td><button class="btn btn-sm btn-success" onclick="ShowDetail(' + v.pid +','+ v.id + ')">内容</button><button class="btn btn-sm btn-info" onclick="UpdateDetail(' + v.id + ')">编辑</button><button class="btn btn-sm btn-danger" onclick="DeleteDetail(' + v.id + ')">删除</button></td></tr>';
            });
            $(dlistsModal).find('tbody').html(tr);

            var title = $('#book_' + id + ' td').eq(2).html();
            $(dlistsModal).find('.modal-title').html(title);

            var paginate = '<ul class="pagination">';
            paginate += '<li><a onclick="getChapters('+ id +',1);" rel="prev">首页</a></li>';

            if( res.last_page > 5 ){

                var start = res.current_page;
                if(res.current_page >= 5){
                    start = res.current_page - 4;
                }else{
                    start = 1;
                }

                var end = 6;
                if(res.last_page - res.current_page > end){
                    end = res.current_page + end;
                }else{
                    end = res.last_page;
                }
                for(var i = start;i<=end;i++){
                    paginate += '<li><a onclick="getChapters('+ id +','+ i +');" rel="prev">' + i + '</a></li>';
                }
            }else{
                if( res.current_page > 1 ){
                    paginate += '<li><a onclick="getChapters('+ id +','+ (res.current_page - 1) +');" rel="prev">上一页</a></li>';
                }
                if( res.current_page < res.total ){
                    paginate += '<li><a onclick="getChapters('+ id +','+ (res.current_page + 1) +');" rel="prev">下一页</a></li>';
                }
            }

            paginate += '<li><a onclick="getChapters('+ id +','+ res.last_page +');" rel="prev">尾页</a></li>';
            paginate += '</ul>';
            $(dlistsModal).find('tfoot td').html(paginate);

            $(dlistsModal).modal('show');
        }else{
            layer.alert('未找到数据');
        }
    }
    //获取文章章节列表
    function getChapters(id,page){
        loading();
        if(parseInt(page) == 0) page = 1;
        $.ajax({
            url:"{!! route('Book.getChapters') !!}",
            data:{id:id,page:page},
            dataType:'json',
            success:function(res){
                showData(id,res);
                loading(true);
            },error:function(res){
                showData(id,res);
                loading(true);
            }
        });
    }
    function updateChapters(id)
    {
        layer.prompt({
            title:'一次更新多少章节?',
            shadeClose:true,
        },function(value, index, elem){
            loading();
            $.get("{!! route('Book.updateChapters') !!}",{'id':id,'number':value},function(res){
                loading(true);
                layer.alert('操作成功',function(){
                    getQuery();
                    layer.closeAll();
                });
            });
        });
    }

    {{--function getListsUpdate()--}}
    {{--{--}}
        {{--layer.prompt({--}}
            {{--title:'一次更新多少本书?',--}}
            {{--shadeClose:true,--}}
        {{--},function(value, index, elem){--}}
            {{--loading();--}}
            {{--$.get("{!! route('Book.updateQueue') !!}",{'number':value},function(res){--}}
                {{--loading(true);--}}
                {{--layer.alert('操作成功',function(){--}}
                    {{--getQuery();--}}
                    {{--layer.closeAll();--}}
                {{--});--}}
            {{--});--}}
        {{--});--}}
        {{--return false;--}}
    {{--}--}}

    function changeUpdateQueueFormType(val)
    {
        if(val < 4){
            $('#updateType_' + val).removeClass('hidden').siblings('.updateType').addClass('hidden');
            if(val == 1){
                $('.xiaoshuoNumber').removeClass('hidden');
            }else{
                $('.xiaoshuoNumber').addClass('hidden');
            }
        }else{
            $('.updateType,.xiaoshuoNumber').addClass('hidden');
        }
    }

    var QueryRequest;

    //定时查询队列数量
    function getQuery()
    {
        window.clearInterval(QueryRequest);
        QueryRequest = setInterval(function(){
            $.get("{!! route('Book.getQueueNumber') !!}",{},function(res){
                $('#queueNumber').text(res);
                if( res == 0 ){
                    window.clearInterval(QueryRequest);
                    return false;
                }
            });
        },3000);
    }

    getQuery();


</script>
<script>
    $(function(){
        $('#checkall').click(function(){
            $(this).attr('checked') ? $('.table input[type=checkbox]').iCheck('check') :  $('.table input[type=checkbox]').iCheck('disable');
        });
    })
</script>
{{--delete--}}
@include('admin.modal.delete' , ['formurl' => route('Book.getDelete')])

{{--createQueue--}}
<div class="modal inmodal" id="createModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInX">
            <form action="{{ route('Book.createQueue') }}" method="get" class="form-horizontal">
                {!! csrf_field() !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">创建采集队列</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">源选择</label>
                        <div class="col-sm-9">
                            <select name="source" class="form-control">
                                {{--@foreach(config('book') as $v)--}}
                                <option value="wx999">999文学</option>
                                {{--<option value="dushu88">88读书网</option>--}}
                            </select>
                            <span class="help-block m-b-none"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">栏目选择</label>
                        <div class="col-sm-9">
                            @foreach($categorys as $v)
                                <label class="i-checks">
                                    <input type="checkbox" name="catid[]" value="{{ $v['id'] }}">
                                    {{ $v['name'] }}
                                </label>
                            @endforeach
                            <span class="help-block m-b-none"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">采集数量</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" name="number" value="{{ old('number') }}" placeholder="100">
                            <span class="help-block m-b-none">采集多少篇</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">每篇章节数量</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" name="zhangjieNumber" value="{{ old('zhangjieNumber') }}" placeholder="89757">
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

{{--更新队列--}}
<div class="modal" id="updateQueueModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInX">
            <form action="{{ route('Book.updateQueue') }}" method="post" class="form-horizontal">
                {!! csrf_field() !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">创建更新队列</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">更新方式</label>
                        <div class="col-sm-9">
                            <select name="updateType" class="form-control" onchange="changeUpdateQueueFormType(this.value);">
                                <option value="1">指定栏目</option>
                                <option value="2">指定范围</option>
                                <option value="3">指定文章</option>
                                <option value="4">修复空白数据</option>
                            </select>
                            <span class="help-block m-b-none"></span>
                        </div>
                    </div>
                    {{--指定栏目--}}
                    <div class="form-group updateType" id="updateType_1">
                        <label class="col-sm-3 control-label">栏目选择</label>
                        <div class="col-sm-9">
                            @foreach($categorys as $v)
                                <label class="i-checks">
                                    <input type="checkbox" name="catid[]" value="{{ $v['id'] }}">
                                    {{ $v['name'] }}
                                </label>
                            @endforeach
                            <span class="help-block m-b-none"></span>
                        </div>
                    </div>
                    {{--指定范围--}}
                    <div class="form-group updateType hidden" id="updateType_2">
                        <label class="col-sm-3 control-label">ID范围</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" name="startId" value="{{ old('startId') }}" placeholder="100">
                            <span class="help-block m-b-none">起始ID</span>
                            <input type="number" class="form-control" name="endId" value="{{ old('endId') }}" placeholder="100">
                            <span class="help-block m-b-none">结束ID</span>
                        </div>
                    </div>
                    {{--指定文章--}}
                    <div class="form-group updateType hidden" id="updateType_3">
                        <label class="col-sm-3 control-label">指定文章ID</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" name="targetId" value="{{ old('targetId') }}" placeholder="89757">
                            <span class="help-block m-b-none"></span>
                        </div>
                    </div>

                    <div class="form-group xiaoshuoNumber">
                        <label class="col-sm-3 control-label">小说数量</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" name="number" value="{{ old('number') }}" placeholder="100">
                            <span class="help-block m-b-none">需要更新的小说本数</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">章节数量</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" name="zhangjieNumber" value="{{ old('zhangjieNumber') }}" placeholder="100">
                            <span class="help-block m-b-none">每本小说需要更新的章节数</span>
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
<div class="modal" id="updateModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInX">
            <form action="{{ route('Book.postUpdate') }}" method="POST" class="form-horizontal">
                {!! csrf_field() !!}
                <input type="hidden" name="id" value="">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">编辑</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">分类</label>
                        <div class="col-sm-10">
                            <select name="catid" id="" class="form-control">
                                <option value="0">请选择</option>
                                @foreach($categorys as $v)
                                    <option value="{{ $v['id'] }}">{{ $v['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">标题</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="title" value="" placeholder="皮皮虾快走">
                            <span class="help-block m-b-none">用来显示的名称</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">简介</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="introduce" id="" cols="30" rows="10"placeholder="皮皮虾我们走"></textarea>
                            <span class="help-block m-b-none"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">最新章节</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="zhangjie" value="" placeholder="皮皮虾已经走了">
                            <span class="help-block m-b-none"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">作者</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="author" value="" placeholder="fa-setting">
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

{{--detail--}}
<div class="modal " id="DetailListsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated flipInX">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">章节列表</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-hover bg-white text-center">
                    <thead>
                    <tr>
                        <td width="50">编号</td>
                        <td width="150" align="left">标题</td>
                        {{--<td>点击量</td>--}}
                        <td width="150">添加时间</td>
                        <td width="150">更新时间</td>
                        <td width="180">操作</td>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5">

                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
                <button type="submit" class="btn btn-primary">确定</button>
            </div>
        </div>
    </div>
</div>
@endsection('content')