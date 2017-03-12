<?php
/**
 * Note: 手工采集
 * User: Liu
 * Date: 2017/3/12
 * Time: 10:13
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
class CollectController extends BaseController
{
    /**
     * 首页
     * @param Request $request
     * @return mixed
     */
    public function getIndex(Request $request)
    {
        $data = [
            'lists' => []
        ];
        return admin_view('collect.index',$data);
    }
}
