<style>
    #clipArea {
        height: 300px;
    }
    #view {
        margin: 0 auto;
        width: 200px;
        height: 200px;
    }
</style>
<div id="clipArea"></div>

<div class="form-group">
    <label class="col-sm-6">
        <input type="file" id="upload_file" class="pull-left">
    </label>
    <div class="col-sm-6">

        <button id="clipBtn" class="btn btn-sm btn-success">截取</button>
    </div>
</div>

<div id="view" class="hidden"></div>

<script src="/skin/js/plugins/photoClip/iscroll-zoom.js"></script>
<script src="/skin/js/plugins/photoClip/hammer.js"></script>
<script src="/skin/js/plugins/photoClip/lrz.all.bundle.js"></script>
<script src="/skin/js/plugins/photoClip/jquery.photoClip.js"></script>
<script>
    //document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);
    $("#clipArea").photoClip({
        size: [{{ $w }}, {{ $h }}],
        outputSize: [{{ $w }}, {{ $h }}],
        file: "#upload_file",
        view: "#view",
        ok: "#clipBtn",
        loadStart: function() {
            //console.log("照片读取中");
        },
        loadComplete: function() {
            //console.log("照片读取完成");
        },
        clipFinish: function(dataURL) {
            {{ $c }}(dataURL,'{{ $i }}');
            layer.closeAll();
            //console.log(dataURL);
        }
    });
</script>
<style>
    #clipBtn{
        width:340px;
        margin:20px;
    }
    #upload_file{
        margin:20px;
    }
</style>