<?php
$a = '/([\u4e00-\u9fa5]{3,5}|(\w){3,16})/i';
$b = preg_match($a , '我快点撒飞+adsefasdfasdfwerfewrqwerweqr');
var_dump($b);
/**
 * test
 * Created by PhpStorm.
 * User: Liu
 * Date: 2017/1/16
 */
if($_POST){
    $url = 'http://fzxingrui.net/channel/singlekeywordquery?word=婚纱';

    $result = curlRequest($url);
    if($result)
    {

        if( strpos($result , '<link') !== false )
        {
            $result = substr( $result , 1 ,strpos($result , '<link') - 1);
            $result = stripcslashes($result);
        }
        exit($result);
        exit(json_decode(json_encode(eval($result))));
    }

}
function curlRequest($url , $data = array())
{
    $ch = curl_init($url);
    curl_setopt($ch , CURLOPT_RETURNTRANSFER , TRUE);
    curl_setopt($ch , CURLOPT_HEADER , 0);
    curl_setopt($ch , CURLOPT_TIMEOUT , 5);
    if(!empty($data))
    {
        $queryStr = http_build_str($data);
        curl_setopt($ch , CURLOPT_POST , 1);
        curl_setopt($ch , CURLOPT_POSTFIELDS , $queryStr);
    }
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Document</title>
    <script src="https://simon8.com/skin/js/jquery.min.js"></script>
</head>
<body>
111
<script>
$(function(){
    $.post('?',{data:1},function(response){
        var data = eval(  response.result );
        console.log(data);
    });
})
</script>
</body>
</html>
