<?php
/**
 * User: Liu
 * Date: 2017/1/9
 * Time: 14:39
 */
/**
 * 载入admin目录模板
 * @param $template
 * @return mixed
 */
function admin_view($template)
{
    $params = func_get_args();//获取函数传入的参数列表 数组
    $params[0] = 'admin.'.$params[0];
    return call_user_func_array('view' ,$params );//调用回调函数，并把一个数组参数作为回调函数的参数
}

/**
 * 载入home目录模板
 * @param $template
 * @return mixed
 */
function home_view($template)
{
    $params = func_get_args();//获取函数传入的参数列表 数组
    $params[0] = 'home.'.$params[0];
    return call_user_func_array('view' ,$params );//调用回调函数，并把一个数组参数作为回调函数的参数
}

/**
 * 载入home目录模板
 * @param $template
 * @return mixed
 */
function wap_view($template)
{
    $params = func_get_args();//获取函数传入的参数列表 数组
    $params[0] = 'wap.'.$params[0];
    return call_user_func_array('view' ,$params );//调用回调函数，并把一个数组参数作为回调函数的参数
}

/**
 * 检测是否是手机号
 * @param $mobile
 * @return int
 */
function is_mobile($mobile)
{
    return preg_match('/1[3|4|5|7|8]{1}\d{9}/' , $mobile);
}

/**
 * 检测是否是邮箱
 * @param $email
 * @return int
 */
function is_email($email)
{
    return preg_match('/^(\w)+(\.\w+)*@(\w)+((\.\w+)+)$/' , $email);
}

/**
 * 上传base64编码的缩略图
 * @param $thumb
 * @return string
 */
function upload_base64_thumb($thumb)
{
    if( empty($thumb) ) return '';
    if( strpos($thumb ,'data:image') === false ) return $thumb;
    $filepath = '/uploads/thumbs/'.date('Ym').'/';//缩略图按月划分
    $fileroot = public_path().$filepath;
    if( !is_dir($fileroot) ) mkdir($fileroot ,0777,true);

    $filename = time().rand(100000,999999);
    $fileext = str_replace('data:image/' , '' , strstr($thumb , ';' ,true));
    in_array($fileext , ['jpg','png','gif','bmp']) or $fileext = 'jpg';//jpeg->jpg
    $filename .= '.' . $fileext;

    if( preg_match('/^(data:\s*image\/(\w+);base64,)/' , $thumb ,$result) )
    {
        $result = file_put_contents($fileroot.$filename , base64_decode(str_replace($result[1] , '' , $thumb)));

        if( $result )
        {
            $thumb = $filepath.$filename;
        }
        else
        {
            $thumb = '';
        }
    }

    return $thumb;
}

/**
 * 下载指定远程图片
 * @param $thumb
 * @param string $dir
 * @return string
 */
function save_remote_thumb($thumb, $dir = 'books')
{
    if( empty($thumb) ) return '';

    $filepath = '/uploads/' . $dir . '/'.date('Ym/d').'/';//缩略图按月划分
    $fileroot = public_path().$filepath;
    if( !is_dir($fileroot) ) mkdir($fileroot ,0777,true);

    $filename = time().rand(100000,999999);
    $fileext = substr($thumb,strrpos($thumb,'.'));
    in_array($fileext , ['jpg','png','gif','bmp']) or $fileext = 'jpg';//jpeg->jpg
    $filename .= '.' . $fileext;

    $result = \File::put($fileroot.$filename , file_get_contents($thumb));

    if( $result )
    {
        if( isImage($fileroot.$filename) ){
            $thumb = $filepath.$filename;
        }else{
           \File::delete($fileroot.$filename);
            $thumb = '';
        }
    }
    else
    {
        $thumb = '';
    }


    return $thumb;
}

/**
 * 生成七牛key
 * @param $file
 * @return mixed
 */
function makeQiNiuKey($file)
{
    //$file = str_replace( array('/' , '\\') , DIRECTORY_SEPARATOR , $file );
    $rule = array(
        public_path() . '/uploads/books/',
        '/uploads/books/',
    );
    return str_replace($rule,'',$file);

}
/**
 * 上传文件到七牛
 * @param $file
 * @param $key
 * @return string
 */
function uploadToQiniu($file, $key = '')
{
    if(empty($file)) return false;
    $upload = new \App\Http\Controllers\Admin\UploadController();
    if(empty($key)) $key = makeQiNiuKey($file);
    //统一分隔符
    $thumb = str_replace( array('/' , '\\') , DIRECTORY_SEPARATOR , $file );
    $file = $upload->put($thumb,$key);
    if(isset($file['key'])){
        return '/' . $file['key'];
    }else{
        return '';
    }
}

/**
 * validate.js
 * @return string
 */
function jquery_validate_js()
{
    return <<<php
    <script src="/skin/js/plugins/validate/jquery.validate.min.js"></script>
    <script src="/skin/js/plugins/validate/messages_zh.min.js"></script>
php;
}

/**
 * 生成jquery.validate的默认设置
 * @return string
 */
function jquery_validate_default()
{
    $js = <<<php
    $.validator.setDefaults({
        highlight: function(a) {
            $(a).closest(".form-group").removeClass("has-success").addClass("has-error")
        },
        success: function(a) {
            a.closest(".form-group").removeClass("has-error").addClass("has-success")
        },
        errorElement: "span",
        errorPlacement: function(a, b) {
            if (b.is(":radio") || b.is(":checkbox")) {
                a.appendTo(b.parent().parent().parent())
            } else {
                a.appendTo(b.parent())
            }
        },
        errorClass: "help-block m-b-none",
        validClass: "help-block m-b-none"
    });
php;
    return $js;

}

/**
 * obj转为数组
 * @param $obj
 * @return mixed
 */
function obj2arr($obj)
{
    if(is_object($obj))
    {
        return json_decode(json_encode($obj) , true);
    }
    return $obj;
}

/**
 * 根据route名称返回URL
 * @param $route
 * @return string
 */
function route2url($route = '')
{
    if(empty($route)) return '/';
    try{
        return route($route);
    }catch (\Exception $exception) {
        return '';
    }
}


/**
 * 调用编辑器
 * @param $id
 * @param string $editor
 * @param string $extends
 * @return bool
 */
function seditor($content = '' , $name = 'content', $editor = 'ueditor', $extends = '')
{

    if( $editor == 'kindeditor' )
    {
        $url = "/plugins/editor/kindeditor/kindeditor.js";
        $lang = "/plugins/editor/kindeditor/lang/zh_CN.js";
        echo "<script charset='utf-8' src='$url'></script>";
        echo "<script charset='utf-8' src='$lang'></script>";
        echo "<script>";
        echo " KindEditor.ready(function(K) { window.editor = K.create('#$name',{width:'100%',cssPath : '/plugins/editor/kindeditor/plugins/code/new.css',resizeMode:0});});";
        echo "</script>";

    }
    else if( $editor == 'ueditor' )
    {
        echo "<script id='content' type='text/plain' style='width:100%;height:500px;' name='{$name}' {$extends}>".$content."</script>";
        echo "<script type='text/javascript' src='/skin/plugins/editor/ueditor/ueditor.config.js'></script>";
        echo "<script type='text/javascript' src='/skin/plugins/editor/ueditor/ueditor.all.js'></script>";
        echo "<script type='text/javascript'> var ue = UE.getEditor('{$name}',{elementPathEnabled:false,contextMenu:[],enableAutoSave: false,saveInterval:500000});</script>";

    }
    else if( $editor == 'markdown' )
    {
        echo "<textarea name='".$name."' data-provide='markdown' {$extends}>".$content."</textarea>";
        echo "<link rel='stylesheet' type='text/css' href='/skin/plugins/editor/markdown/bootstrap-markdown.min.css' />";
        echo "<script type='text/javascript' src='/skin/plugins/editor/markdown/markdown.js'></script>";
        echo "<script type='text/javascript' src='/skin/plugins/editor/markdown/to-markdown.js'></script>";
        echo "<script type='text/javascript' src='/skin/plugins/editor/markdown/bootstrap-markdown.js'></script>";
        echo "<script type='text/javascript' src='/skin/plugins/editor/markdown/bootstrap-markdown.zh.js'></script>";

    }
    return false;
}

/**
 * 简单处理图片链接
 * @param string $img
 * @return string
 */
function imgurl($img = '')
{
    if(!$img)
    {
        return '/skin/manager/images/nopic.png';
    }
    return $img;
}

/**
 * 处理书本封图片
 * @param string $img
 * @return string
 */
function bookimg($img = '')
{
    if(!$img)
    {
        return asset('/skin/default/images/nocover.jpg');
    }
    if(substr($img, 0,4) !== 'http'){
        //使用七牛链接
        if(strpos($img , '/uploads/') === false){
            $image = config('upload.domain') . $img;
            return asset('skin/default/images/lazy.gif') . '" class="lazy" data-original="'.$image;
        }
        return asset($img);
    }
    return $img;
}

/**
 * 生成书本链接
 * @param $catid
 * @param int $id
 * @param int $aid
 * @return string
 */
function bookurl($catid, $id = 0, $aid = 0){
    if($aid)
    {
        if(is_numeric($aid)){
            return route('BookContent',[
                'catid' => $catid,
                'id' => $id,
                'aid'=> $aid,
            ]);
        }else if($aid == 'chapter'){
            return route('BookChapter',[
                'catid' => $catid,
                'id' => $id,
            ]);
        }else{
            return route('BookLastContent',[
                'catid' => $catid,
                'id' => $id,
            ]);
        }
    }
    if($id){
        return route('BookLists',[
            'catid' => $catid,
            'id' => $id,
        ]);
    }
    return route('BookCat',[
        'catid' => $catid,
    ]);
}

/**
 * 生成手机端链接
 * @param $catid
 * @param int $id
 * @param int $aid
 * @return mixed
 */
function wapurl($catid = 0, $id = 0, $aid = 0){
    $baseUrl = env('APP_MOBILE_DOMAIN');
    if(!$catid) return $baseUrl;
    $url = bookurl($catid,$id,$aid);
    return str_replace(url() , $baseUrl, $url);
}
/**
 * 日志记录
 * @param $message
 */
function logwrite($message){
    if(is_array($message) || is_object($message)){
        \Log::debug("\n". var_export($message , true));
    }else{
        \Log::debug("\n". $message);
    }
}

/**
 * 模拟蜘蛛访问获取页面HTML
 * @param $url
 * @param string $spider
 * @return mixed
 * @throws Exception
 */
function request_spider($url, $spider = 'baidu')
{
    switch ($spider){
        case 'baidu':
            $ip =  '220.181.108.'.rand(1,255);
            $userAgent = 'Mozilla/5.0 (compatible; Baiduspider/2.0; +http://www.baidu.com/search/spider.html)';
            break;
        default:
            $ip =  '220.181.108.'.rand(1,255);
            $userAgent = 'Mozilla/5.0 (compatible; Baiduspider/2.0; +http://www.baidu.com/search/spider.html)';
            break;
    }

    $ch = curl_init($url);
    curl_setopt($ch , CURLOPT_RETURNTRANSFER , true);
    curl_setopt($ch , CURLOPT_HEADER , 0);
    curl_setopt($ch , CURLOPT_TIMEOUT , 20);
    curl_setopt($ch , CURLOPT_HTTPHEADER , [
        'X-FORWARDED-FOR:'.$ip.'',
        'CLIENT-IP:'.$ip.''
    ]);
    curl_setopt($ch , CURLOPT_USERAGENT , $userAgent);
    curl_setopt($ch , CURLOPT_CONNECTTIMEOUT , 20);
    $content = curl_exec($ch);
    $error_message = curl_error($ch);
    curl_close($ch);
    if( empty($error_message) ){
        return $content;
    }else{
        throw new Exception($error_message);
    }
}

/**
 * 检测是否是图片
 * @param $image
 * @return bool
 */
function isImage($image)
{
    $info = @getimagesize($image);
    if(!$info) return false;
    //$ext = image_type_to_extension($info[2]);
    return true;
}

/**
 * 静态文件
 * @param $file
 * @return string
 */
function staticPath($file)
{
    //$staticDomain = env('STATIC_DOMAIN');
    $staticDomain = 'http://static.txshu.com';
    return $staticDomain . $file;
}


/**
 * 主动推送给百度
 * @param $url
 * @param string $type
 * @return mixed
 */
function post_url_to_baidu($url , $type = 'pc'){
    if(is_array($url)){
        $url = implode("\n", $url);
    }
    if($type == 'pc'){
        $api = 'http://data.zz.baidu.com/urls?site=www.txshu.com&token=IyoSxgVWMlEdD9fL';
    }else{
        $api = 'http://data.zz.baidu.com/urls?site=m.txshu.com&token=IyoSxgVWMlEdD9fL';
    }
    $ch = curl_init();
    $options =  array(
        CURLOPT_URL => $api,
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => $url,
        CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
    );
    curl_setopt_array($ch, $options);
    $result = curl_exec($ch);
    return $result;
}