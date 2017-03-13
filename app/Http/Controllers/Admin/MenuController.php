<?php
/**
 * 后台管理菜单
 * 层级最多两级
 * User: Liu
 * Date: 2017/1/13
 */
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Models\Admin\Menu;
use Validator;
use Route;
class MenuController extends BaseController
{
    protected $Menu;

    public function __construct()
    {
        parent::__construct();
        $this->Menu = new Menu();
    }

    public function getIndex()
    {
        $lists = $this->Menu->lists();
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
     * 创建菜单
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(Request $request)
    {
        $data = $request->all();
        $validator = $this->validator_create($data);
        if($validator->fails())
        {
            $this->throwValidationException(
                $request , $validator
            );
        }
        $result = $this->Menu->create_menu($data);
        if($result)
        {
            return redirect()->route('Menu.getIndex')->with('Message' , '添加成功');
        }
        else
        {
            return back()->withErrors('添加失败')->withInput();
        }
    }

    /**
     * 更新菜单
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postUpdate(Request $request)
    {
        $data = $request->all();
        $item = isset($data['id']) ? $this->Menu->find($data['id']) : false;
        if(!$item)
        {
            return back()->withErrors('该菜单不存在，请先添加')->withInput();
        }
        $validator = $this->validator_create($data);
        if($validator->fails())
        {
            $this->throwValidationException(
                $request , $validator
            );
        }

        $result = $this->Menu->update_menu($item , $data);

        if($result)
        {
            return redirect()->route('Menu.getIndex')->with('Message' , '修改成功');
        }
        else
        {
            return back()->withErrors('修改失败')->withInput();
        }
    }

    /**
     * 删除菜单
     * @param Request $request
     */
    public function getDelete(Request $request)
    {
        $id = $request->id;
        $this->Menu->delete_menu($id);
        return redirect()->route('Menu.getIndex')->with('Message' , '删除成功');
    }
}