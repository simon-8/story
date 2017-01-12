<?php
/**
 * 后台基类控制器
 * User: Liu
 * Date: 2017/1/12
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    protected static $userid;
    public function __construct()
    {
        $userinfo = session('userinfo');
        if( $userinfo )
        {

        }
        else
        {
            self::$userid = 0;
        }
    }

}