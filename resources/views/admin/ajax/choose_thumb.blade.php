@if(isset($images))

    @foreach($images as $t)
        <div class="pull-left thumb_detail" style="" data-src="{{ $t }}">
            <img src="{{ $t }}" alt="" width="{{ $w }}">
        </div>
    @endforeach
    <script>
        $(function(){
            $('.thumb_detail').click(function(){
                var src = $(this).attr('data-src');
                var i = '{{ $i }}';
                callback(src,i);
                layer.closeAll();
            });
        })
    </script>
    <style>
        .thumb_detail{
            width: {{ $w }}px;
            height: {{ $h }}px;
            margin: 5px 5px;
            overflow: hidden;
            line-height: 100px;
            border: 1px solid #D8D0D0;
            cursor:pointer;
        }
    </style>

@else

    @foreach($folder as $t)
        <div class="folder-div pull-left" style="margin:0 10px;" title="点击查看该文件夹内部图片" data-name="{{ $t }}">
            <div class="folder-img">
                <img src="/skin/manager/images/folder.gif" alt="点击查看该文件夹内部图片" width="100">
            </div>
            <div class="text-center folder-name">
                {{ $t }}
            </div>
        </div>
    @endforeach
    <style>
        .folder-div{cursor: pointer;}
        .folder-div:hover{color:red;}
        .folder-img{}
        .folder-name{
            font-size: 15px;
            margin: 5px 0;
            font-weight: bold;
            border: 1px solid #eee;
        }
    </style>
    <script>
        $(function(){
            $('.folder-div').click(function(){
                var n = $(this).attr('data-name');
                $.post(AJPath,{ac:'choose_thumb_detail',name:n,i:'{{ $i }}',w:'{{ $w }}',h:'{{ $h }}'},function(data){
                    layer.open({
                        area:['930px','500px'],
                        title:'图片列表',
                        type:1,
                        content:data
                    });
                });
            });
        })
    </script>

@endif