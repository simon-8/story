@extends('layout.admin')

@section('content')
    <div class="ibox float-e-margins">

        <form method="post" class="form-horizontal" action="{{ isset($id) ? route('Article.postUpdate') : route('Article.postCreate') }}" id="sform">
            {!! csrf_field() !!}
            <div class="col-sm-12 col-md-8">
                <div class="ibox-title">
                    @if(isset($id))
                        <h5>编辑文章</h5>
                        <input type="hidden" name="id" value="{{ $id }}">
                    @else
                        <h5>添加文章</h5>
                    @endif
                </div>
                <div class="ibox-content">

                    <div class="form-group">
                        <label class="col-sm-1 control-label">标题</label>
                        <div class="col-sm-11">
                            <input id="title" type="text" class="form-control" name="title" value="{{ isset($title) ? $title : old('title') }}">
                            <span class="help-block m-b-none">显示的标题</span>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-1 control-label">内容</label>
                        <div class="col-sm-11">
                            <script id="content" type="text/plain" style="width:100%;height:500px;" name="content">{!! isset($content) ? $content : old('content') !!}</script>
                            {{ seditor('content') }}
                            <span class="help-block m-b-none">文章内容</span>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button class="btn btn-primary" type="submit">保存内容</button>
                            <a class="btn btn-white" href="{{ route('Article.getIndex') }}">返回</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="ibox-title">
                    <h5>其他设置</h5>
                </div>
                <div class="ibox-content">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">分类</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="catid" value="{{ isset($catid) ? $catid : old('catid') }}">
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">标签</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="tag" value="{{ isset($tag) ? $tag : old('tag') }}">
                            <div class="input-group">
                                <a id="tag_choice">从常用标签库里选择</a>
                            </div>
                            <div class="form-group tag-list" id="tagcloud" style="border:none;"></div>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">作者</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="" value="">
                            <span class="help-block m-b-none">仅支持数字和字母的组合</span>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">状态</label>
                        <div class="col-sm-10">
                            <div class="onoffswitch">
                                <input type="checkbox" class="onoffswitch-checkbox" id="status" name="status" {{ isset($status) && $status ? 'checked' : ''}} value="1">
                                <label class="onoffswitch-label" for="status">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                            <span class="help-block m-b-none">仅支持数字和字母的组合</span>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">图片</label>
                        <div class="col-sm-10">
                            <img src="{{ imgurl(isset($thumb) ? $thumb : old('thumb')) }}" id="pthumb" width="220" height="140" onclick="preview(this.src,220,140);" />
                            <input type="hidden" id="thumb" name="thumb" value="{{ isset($thumb) ? $thumb : old('thumb') }}"/>
                            <button class="btn btn-sm btn-success" type="button" onclick="Sthumb('thumb',220,140,'callback');" style="margin-top: 10px;width: 220px;">上传</button>
                            <button class="btn btn-sm btn-primary" type="button" onclick="Schoose_thumb('thumb',220,140);" style="width: 220px;">相册选择</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- jQuery Validation plugin javascript-->
    {!! jquery_validate_js() !!}
    <script>

        $(function(){
            {!! jquery_validate_default() !!}

            $("#sform").validate({
                debug:false,
                rules:{
                    title:{
                        required:true,
                        minlength:4,
                    },
                    content:{
                        required:true,
                        minlength:4,
                    },
                    catid:{
                        required:true,
                    },
                }
            });
        });
        $('#tag_choice').click(function(){
            tagcloud();
            $('#tagcloud').attr('style','');
        });
        function tagcloud(i,d){
            $.ajax({
                url:AJPath,
                type:'post',
                dataType:'json',
                data:{ac:'tagcloud'},
                success:function(data){
                    if(data.code == 1){
                        var tag = '';
                        $.each(data.msg,function(k,t){
                            tag += '<a href="javascript:" class="label label-info">'+t.name+'</a>';
                        });
                        $('#tagcloud').html(tag);
                    }else{
                        layer.msg(data.msg,{icon:0});
                    }
                },error:function(data){
                    layer.msg('request error , please try again later',{icon:0});
                }
            })
        }
    </script>
@endsection('content')