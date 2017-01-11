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
