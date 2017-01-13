<?php
/**
 * 菜单
 * User: Liu
 * Date: 2017/1/13
 */
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Models\Admin\Menu;

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
        return admin_view('menu.index');
    }

    public function getCreate(Request $request)
    {

    }

    public function postUpdate(Request $request)
    {

    }

    public function getDelete(Request $request)
    {

    }
}