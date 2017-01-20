<?php
/**
 * 菜单
 * User: Liu
 * Date: 2017/1/13
 */
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Models\Admin\Menu;
use Validator;
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

    public function getCreate(Request $request)
    {

        return admin_view('menu.create');
    }

    protected function validator_create($data)
    {
        return Validator::make($data , [
            'name'   => 'required|string',
            'prefix' => 'required|string',
            'route'  => 'required|string',
        ]);
    }

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

    public function postUpdate(Request $request)
    {

    }

    public function getDelete(Request $request)
    {
        $itemid = $request->itemid;
        $this->Menu->delete_menu($itemid);
    }
}