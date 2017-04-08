<?php
/**
 * Note: 七牛上传类
 * User: Liu
 * Date: 2017/4/4
 * Time: 11:11
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Qiniu\Storage\UploadManager;
use Qiniu\Auth;

class UploadController extends BaseController
{
    protected $config;
    protected $upManager;
    protected $auth;
    protected $token;
    protected $error;

    public function __construct()
    {
        parent::__construct();

        $config = config('upload');
        $this->config = $config;
        //初始化 UploadManager 对象并进行文件的上传
        $this->upManager = new UploadManager();
        $this->auth = new Auth($config['accessKey'], $config['secretKey']);
        $this->token = $this->getToken($config['bucketName']);
    }

    /**
     * 获取错误信息
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * 生成上传 Token
     * @param $bucketName
     * @return string
     */
    protected function getToken($bucketName)
    {
        return $this->auth->uploadToken($bucketName);
    }

    /**
     * 上传文件
     * @param $file
     * @param string $key
     * @return mixed
     */
    public function put($file, $key = '')
    {
        list($ret, $error) = $this->upManager->putFile($this->token, $key, $file);
        if ($error !== null) {
            $this->error = $error;
            return $error;
        } else {
            return $ret;
        }
    }

    /*public function get($key)
    {
        //baseUrl构造成私有空间的域名/key的形式
        $baseUrl = $this->config['domain'] . $key;
        $authUrl = $this->auth->privateDownloadUrl($baseUrl);
        return $authUrl;
    }*/
}