<?php
/**
 * Note:
 * User: Liu
 * Date: 2017/2/23
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use DB;
class WeixinController extends BaseController
{

    public function getIndex(Request $request)
    {
        $lists = DB::table('weixin_chat')->paginate();
        $data = [
            'lists' => $lists,
        ];
        return admin_view('weixin.index' , $data);
    }

    public function getUsers(Request $request)
    {

    }
}