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

    /**
     * 创建用户
     * @return mixed
     */
    public function getCreate()
    {
        return admin_view('manager.create');
    }

    /**
     * 创建校验
     * @param $data
     * @return mixed
     */
    protected function validate_create($data)
    {
        return Validator::make($data , [
            'username' => 'required|string|min:4|max:50|unique:managers',
            'truename' => 'required|string',
            'password' => 'required|string|min:4|max:255',
            'email'    => 'required|string|email|unique:managers',
        ]);
    }

    /**
     * 创建用户
     * @param Request $request
     * @param AuthController $auth
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(Request $request)
    {
        $data = $request->all();

        $validator = $this->validate_create($data);
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

    /**
     * 更新用户
     * @param $id
     * @return mixed
     */
    public function getUpdate($id)
    {
        $data = $this->Manager->find($id);
        if(!$data){
            abort(404 , '用户不存在');
        }
        return admin_view('manager.create' , $data);
    }

    /**
     * 更新校验
     * @param $data
     * @param bool $repassword
     * @return \Illuminate\Validation\Validator
     */
    protected function validate_update($data , $repassword = false)
    {
        $validate_rule = [
            'username' => 'required|string|min:4|max:50|unique:managers,username,' . $data['id'],
            'truename' => 'required|string',
            'password' => 'required|string|min:4|max:255',
            'email'    => 'required|string|email|unique:managers,email,' . $data['id'],
        ];
        if(false == $repassword)
        {
            unset($validate_rule['password']);
        }
        return Validator::make($data , $validate_rule);
    }

    /**
     * 更新用户
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postUpdate(Request $request)
    {
        $data = $request->all();
        $repassword = $data['password'] ? true : false;
        $validator = $this->validate_update($data , $repassword);

        if( $validator->fails() )
        {
            $this->throwValidationException(
                $request , $validator
            );
        }
        $result = $this->Manager->update_manager($data);
        if($result)
        {
            return redirect()->route('Manager.getIndex');
        }
        else
        {
            return back()->withErrors('更新失败')->withInput();
        }
    }

    public function getDelete(Request $request)
    {
        $user = $this->Manager->find($request->id);
        if($user)
        {
            if($user->id == 1)
            {
                return redirect()->route('Manager.getIndex')->withErrors('内置管理员账户无法删除');
            }

            $result = $user->delete();
            if($result)
            {
                return redirect()->route('Manager.getIndex')->with('Message' , '删除成功');
            }
            else
            {
                return redirect()->route('Manager.getIndex')->withErrors('删除失败');
            }
        }
        else
        {
            return redirect()->route('Manager.getIndex')->withErrors('用户不存在');
        }
    }


}