<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/1/9
 * Time: 16:36
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin\Manager;
class AuthController extends Controller
{
    protected $Manager;
    public function __construct(Manager $manager)
    {
        $this->Manager = $manager;
    }

    protected function validate_login($data)
    {
        return Validator::make($data , [
            'username' => 'required|string|min:4|max:10',
            'password' => 'required|string|min:4|max:10',
        ]);
    }

    public function getLogin()
    {
        return admin_view('auth.login');
    }

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
                echo 'ok';
            }
            else
            {
                echo 'password is error';
            }
        }
        else
        {
            echo 'user is not found';
        }
    }

    protected function validate_register($data)
    {
        return Validator::make($data , [
            'username' => 'required|string|min:4|max:10',
            'password' => 'required|string|min:4|max:10',
            'password_confirm' => 'same:password',
        ] , [
            'username.required' => '请填写用户名',
            'password.required' => '请填写密码',
            'username.min'     => '用户名的长度应该在4~10之间',
            'password.min'     => '密码的长度应该在4~10之间',
            'password_confirm.same' => '两次密码不一致',
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
            return back()->withErrors('密码错误');
        }
    }
}