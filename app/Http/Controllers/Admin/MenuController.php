<?php
/**
 * 后台管理菜单
 * 层级最多两级
 * User: Liu
 * Date: 2017/1/13
 */
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Repositories\MenuRepository;

use Validator;
use Route;
class MenuController extends BaseController
{
    /**
     * @param MenuRepository $repository
     * @return mixed
     */
    public function getIndex(MenuRepository $repository)
    {
        $lists = $repository->lists();
        $data = [
            'lists' => $lists,
        ];
        return admin_view('menu.index' , $data);
    }

    /**
     * 创建菜单
     * @param Request $request
     * @return mixed
     */
    public function getCreate(Request $request)
    {
        return admin_view('menu.create');
    }

    /**
     * 创建校验规则
     * @param $data
     * @return \Illuminate\Validation\Validator
     */
    protected function validator_create($data)
    {
        return Validator::make($data , [
            'name'   => 'required|string',
            'prefix' => 'required|string',
            'route'  => 'required|string',
        ]);
    }

    /**
     * 新增
     * @param Request $request
     * @param MenuRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postCreate(Request $request, MenuRepository $repository)
    {
        $data = $request->all();
        $validator = $this->validator_create($data);
        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }
        $result = $repository->create_menu($data);
        if ($result) {
            return redirect()->route('Menu.getIndex')->with('Message', '添加成功');
        } else {
            return back()->withErrors('添加失败')->withInput();
        }
    }

    /**
     * 更新
     * @param Request $request
     * @param MenuRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postUpdate(Request $request, MenuRepository $repository)
    {
        $data = $request->all();
        $item = isset($data['id']) ? $repository->find($data['id']) : false;
        if (!$item) {
            return back()->withErrors('该菜单不存在，请先添加')->withInput();
        }
        $validator = $this->validator_create($data);
        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }

        $result = $repository->update_menu($item, $data);

        if ($result) {
            return redirect()->route('Menu.getIndex')->with('Message', '修改成功');
        } else {
            return back()->withErrors('修改失败')->withInput();
        }
    }

    /**
     * 删除
     * @param Request $request
     * @param MenuRepository $repository
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function getDelete(Request $request, MenuRepository $repository)
    {
        $id = $request->id;
        $repository->delete_menu($id);
        return redirect()->route('Menu.getIndex')->with('Message' , '删除成功');
    }
}