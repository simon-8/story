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
        return admin_view('setting.index');
    }

    public function postIndex()
    {

    }
}