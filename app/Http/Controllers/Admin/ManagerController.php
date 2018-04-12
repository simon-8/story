<?php
/**
 * 管理员相关
 * Created by PhpStorm.
 * User: Liu
 * Date: 2017/1/16
 */
namespace App\Http\Controllers\Admin;

use App\Repositories\ManagerRepository;

use Illuminate\Http\Request;
use Validator;

use App\Http\Controllers\Admin\BaseController;


class ManagerController extends BaseController
{
    /**
     * @param ManagerRepository $repository
     * @return mixed
     */
    public function getIndex(ManagerRepository $repository)
    {
        $lists = $repository->lists();
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
     * @param ManagerRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postCreate(Request $request, ManagerRepository $repository)
    {
        $data = $request->all();

        $validator = $this->validate_create($data);
        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }

        $result = $repository->create($data);
        if ($result) {
            return redirect()->route('Manager.getIndex');
        } else {
            return back()->withErrors('创建失败')->withInput();
        }
    }

    /**
     * 更新用户
     * @param ManagerRepository $repository
     * @param $id
     * @return mixed
     */
    public function getUpdate(ManagerRepository $repository, $id)
    {
        $data = $repository->find($id);
        if (!$data) {
            abort(404, '用户不存在');
        }
        return admin_view('manager.create', $data);
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
     * @param ManagerRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postUpdate(Request $request, ManagerRepository $repository)
    {
        $data = $request->all();
        $repassword = $data['password'] ? true : false;
        if (empty($data['password'])) unset($data['password']);
        $validator = $this->validate_update($data, $repassword);

        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }

        $result = $repository->update($data);
        if ($result) {
            return redirect()->route('Manager.getIndex');
        } else {
            return back()->withErrors('更新失败')->withInput();
        }
    }


    /**
     * 删除
     * @param Request $request
     * @param ManagerRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function getDelete(Request $request, ManagerRepository $repository)
    {
        $user = $repository->find($request->id);
        if (!$user) {
            return redirect()->route('Manager.getIndex')->withErrors('用户不存在');
        }
        if ($user->id == 1) {
            return redirect()->route('Manager.getIndex')->withErrors('内置管理员账户无法删除');
        }

        $result = $user->delete();
        if ($result) {
            return redirect()->route('Manager.getIndex')->with('Message', '删除成功');
        } else {
            return redirect()->route('Manager.getIndex')->withErrors('删除失败');
        }
    }

}