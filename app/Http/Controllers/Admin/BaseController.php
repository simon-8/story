<?php
/**
 * 后台基类控制器
 * User: Liu
 * Date: 2017/1/12
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Admin\Manager;
class BaseController extends Controller
{
    protected static $userid;
    protected static $username;
    protected static $truename;
    protected static $user;
    protected $Manager;
    public function __construct()
    {
        $this->Manager = new Manager();
        $this->login();
    }

    protected function login()
    {
        $userinfo = session('userinfo');
        if( $userinfo )
        {
            $user = $this->Manager->findByUsername($userinfo['username']);
            if( $user )
            {
                if( $userinfo['password'] == $this->Manager->session_use_password($user->password) )
                {
                    self::$userid = $user->id;
                    self::$username = $user->username;
                    self::$truename = $user->truename;
                    self::$user = $user;
                    return true;
                }
                else
                {
                    //密码不匹配，确认密码
                    return redirect()->route('getEnterpassword');
                }
            }
        }
        return redirect()->route('getAdminLogin');
    }
}