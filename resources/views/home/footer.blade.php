@if(count($firendLinks))
<div class="link">
    友情链接：
    @foreach($firendLinks as $v)
        <a href="{!! $v['linkurl'] !!}" target="_blank">{{ $v['title'] }}</a>
    @endforeach
</div>
@endif

<div id="footer">
    <p>
        本站所有小说为转载作品，所有章节均由网友上传，转载至本站只是为了宣传本书让更多读者欣赏。
    </p>
    <p>
        {{ $SET['powerby'] }}
    </p>
</div>