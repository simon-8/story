<?php
/**
 * 管理员相关
 * Created by PhpStorm.
 * User: Liu
 * Date: 2017/1/16
 */
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Validator;

use App\Http\Controllers\Admin\BaseController;


class ManagerController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getIndex()
    {
        $lists = $this->Manager->lists();
        $data = [
            'lists' => $lists,
        ];
        return admin_view('manager.index' , $data);
    }

    public function getCreate()
    {
        return admin_view('manager.create');
    }


    /**
     * 注册校验
     * @param $data
     * @return mixed
     */
    protected function validate_register($data)
    {
        return Validator::make($data , [
            'username' => 'required|string|min:4|max:50|unique:managers',
            'truename' => 'required|string',
            'password' => 'required|string|min:4|max:255',
            'password_confirm' => 'same:password',
        ]);
    }
    /**
     * 创建用户
     * @param Request $request
     * @param AuthController $auth
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postCreate(Request $request)
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
            return redirect()->route('Manager.getIndex');
        }
        else
        {
            return back()->withErrors('创建失败')->withInput();
        }
    }

    public function getUpdate($id)
    {
        $data = $this->Manager->find($id);
        if($data) return admin_view('manager.create' , $data);
    }

    public function postUpdate(Request $request)
    {
        $data = $request->all();

    }

    public function getDelete($id)
    {
        var_dump($id);
    }
}