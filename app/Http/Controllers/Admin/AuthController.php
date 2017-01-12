<?php
/**
 * 登录相关
 * User: admin
 * Date: 2017/1/9
 * Time: 16:36
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Manager;
use Validator;
use Auth;
class AuthController extends Controller
{
    protected $Manager;
    public function __construct(Manager $manager)
    {
        $this->middleware('admin.guest' , ['except' =>  'getLogout']);
        $this->Manager = $manager;
    }

    /**
     * 登录验证
     * @param $data
     * @return mixed
     */
    protected function validate_login($data)
    {
        return Validator::make($data , [
            'username' => 'required|string|min:4|max:255',
            'password' => 'required|string|min:4|max:255',
        ]);
    }

    /**
     * 用户登录
     * @return mixed
     */
    public function getLogin()
    {
        return admin_view('auth.login');
    }

    /**
     * 用户登录
     * @param Request $request
     */
    public function postLogin(Request $request)
    {
        $data = $request->all();
        $validator = $this->validate_login($data);
        if( $validator->fails() )
        {
            $this->throwValidationException(
                $request , $validator
            );
        }
        $user = $this->Manager->findByUsername($data['username']);
        if($user)
        {
            if( $this->Manager->compare_password($data['password'] , $user->password) )
            {
                $this->make_login_session($user);
                return redirect(route('getAdminIndex'));
            }
            else
            {
                return back()->withErrors('密码不正确')->withInput();
            }
        }
        else
        {
            return back()->withErrors('用户不存在')->withInput();
        }
    }


    protected function make_login_session($user)
    {
        $userinfo = [
            'userid'    => $user->id,
            'username'    => $user->username,
            'password'    => substr(md5($user->password) ,0 ,8)
        ];

        session(['userinfo' => $userinfo]);
    }
    /**
     * 注册校验
     * @param $data
     * @return mixed
     */
    protected function validate_register($data)
    {
        return Validator::make($data , [
            'username' => 'required|string|min:4|max:50|unique',
            'password' => 'required|string|min:4|max:255',
            'password_confirm' => 'same:password',
        ]);
    }


    /**
     * 用户注册
     * @return mixed
     */
    public function getRegister()
    {
        return admin_view('auth.register');
    }


    /**
     * 用户注册
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postRegister(Request $request)
    {
        $data = $request->all();
        $validator = $this->validate_register($data);
        if( $validator->fails() )
        {
            $this->throwValidationException(
                $request, $validator
            );
        }
        $result = $this->Manager->create_manager($data);
        if($result)
        {
            return redirect(route('getAdminLogin'));
        }
        else
        {
            return back()->withErrors('创建失败')->withInput();
        }
    }


    /**
     * 退出登录
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getLogout()
    {
        session()->forget('userid');
        return redirect(route('getAdminLogin'));
    }
}