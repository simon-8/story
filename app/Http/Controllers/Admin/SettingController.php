<?php
/**
 * Note: 系统配置
 * User: Liu
 * Date: 2017/2/7
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Admin\Setting;
use Validator;
class SettingController extends BaseController
{
    protected $Setting;

    public function __construct()
    {
        parent::__construct();
        $this->Setting = new Setting();
    }

    /**
     * 首页
     * @return mixed
     */
    public function getIndex()
    {
        $lists = $this->Setting->lists();
        $data = [
            'lists' => $lists
        ];
        return admin_view('setting.index',$data);
    }

    /**
     * 首页批量编辑
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postIndex(Request $request)
    {
        $data = $request->data;
        $result = $this->Setting->update_setting($data);
        if($result)
        {
            return redirect()->route('Setting.getIndex')->with('Message' ,'更新成功');
        }
        else
        {
            return back()->withErrors('更新失败')->withInput();
        }
    }


    /**
     * 创建新菜单项
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data , [
            'item'  => 'required',
            'name'  => 'required',
            'value' => 'required'
        ]);
        if($validator->fails())
        {
            $this->throwValidationException(
                $request,
                $validator
            );
        }
        $result = $this->Setting->create_setting($data);
        if($result)
        {
            return redirect()->route('Setting.getIndex')->with('Message' ,'添加成功');
        }
        else
        {
            return back()->withErrors('添加失败')->withInput();
        }
    }


    /**
     * 单个删除
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDelete(Request $request)
    {
        $result = $this->Setting->delete_setting($request->id);
        if($result)
        {
            return redirect()->route('Setting.getIndex')->with('Message' ,'删除成功');
        }
        else
        {
            return back()->withErrors('删除失败')->withInput();
        }
    }

    public function getCollect()
    {
        return 'test';
    }
}