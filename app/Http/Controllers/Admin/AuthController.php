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

class AuthController extends Controller
{

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
        $validator = $this->validate_login($request->all());
        if( $validator->fails() )
        {
            var_dump('error');
        }
        echo 'ok';
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

    public function getRegister()
    {
        return admin_view('auth.register');
    }

    public function postRegister(Request $request)
    {
        $validator = $this->validate_register($request->all());
        if( $validator->fails() )
        {
            $this->throwValidationException(
                $request, $validator
            );
        }

    }
}