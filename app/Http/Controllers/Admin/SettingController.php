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

    public function getIndex()
    {
        $lists = $this->Setting->lists();
        $data = [
            'lists' => $lists
        ];
        return admin_view('setting.index',$data);
    }

    public function postIndex(Request $request)
    {
        $data = $request->all();
        $this->Setting->update_setting($data);
    }

    /**
     * 创建新菜单项
     * @param Request $request
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
}