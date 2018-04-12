@extends('layout.admin')

@section('content')
    <div class="ibox float-e-margins">

        <form method="post" class="form-horizontal" action="{{ route('Book.updateChapter') }}" id="sform">
            {!! csrf_field() !!}
            <div class="col-sm-12 col-md-8">
                <div class="ibox-title">
                    <h5>编辑章节</h5>
                    <input type="hidden" name="id" value="{{ $id }}">
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
                            {{--{{ seditor($content , 'content','markdown' ,'rows=10') }}--}}
                            {{ seditor(isset($content) ? $content : old('content') , 'content','ueditor') }}
                            <span class="help-block m-b-none">文章内容</span>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button class="btn btn-primary" type="submit">保存内容</button>
                            <a class="btn btn-white" href="{{ route('Book.getIndex') }}">返回</a>
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
                        <label class="col-sm-2 control-label">状态</label>
                        <div class="col-sm-10">
                            <div class="onoffswitch">
                                <input type="checkbox" class="onoffswitch-checkbox" id="status" name="status" {{ isset($status) && $status ? 'checked' : ''}} value="1">
                                <label class="onoffswitch-label" for="status">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                            <span class="help-block m-b-none"></span>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                </div>
            </div>
        </form>
    </div>

@endsection('content')