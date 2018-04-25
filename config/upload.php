<?php
/**
 * Note: 七牛云上传配置
 * User: Liu
 * Date: 2017/4/4
 * Time: 11:12
 */
return [

    'domain'     => env('IMG_URL'),

    'accessKey'  => env('QINIU_ACCESS_KEY'),

    'secretKey'  => env('QINIU_SECRET_KEY'),

    'bucketName' => env('QINIU_BUCKET_NAME'),

];