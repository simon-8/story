<?php
/**
 * Created by PhpStorm.
 * User: admin
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
    $params = func_get_args();
    $params[0] = 'admin.'.$params[0];
    return call_user_func_array('view' ,$params );
}

/**
 * 载入home目录模板
 * @param $template
 * @return mixed
 */
function home_view($template)
{
    $params = func_get_args();
    $params[0] = 'home.'.$params[0];
    return call_user_func_array('view' ,$params );
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
 * 上传base64编码的图片
 * @param $thumb
 * @return string
 */
function upload_base64_pic($thumb)
{
    if( empty($thumb) ) return '';
    if( strpos($thumb ,'data:image') === false ) return $thumb;
    $filepath = '/uploads/'.date('Ym/d').'/';
    $fileext = str_replace('data:image/' , '' , strstr($thumb , ';' ,true));
    $filename = date('YmdHis').'_'.rand(10000,99999) . $fileext;
    if( preg_match('/^(data:\s*image\/(\w+);base64,)/' , $thumb ,$result) )
    {
        \Storage::disk('local')->put($filepath.$filename , base64_decode(str_replace($result[1] , '' , $thumb)));
        if( \Storage::disk('local')->has($filepath.$filename) )
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