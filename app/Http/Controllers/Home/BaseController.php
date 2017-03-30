<?php
/**
 * Note: 前台基类控制器
 * User: Liu
 * Date: 2017/3/30
 */
namespace App\Http\Controllers\Home;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;


use App\Models\Admin\Setting;



class BaseController extends Controller
{
    public function __construct(Request $request)
    {
        if(!\Request::ajax() && \Request::isMethod('get')){

            //System Setting
            $setting = new Setting();
            $settings = [];
            foreach($setting->lists() as $v){
                $settings[$v['item']] = $v['value'];
            }
            view()->share('SET',$settings);

            //Normal param
            view()->share('SET',$settings);
            $catid = empty($request->catid) ? 0 : intval($request->catid);
            view()->share('SET',$settings);
            $id = empty($request->id) ? 0 : intval($request->id);
            view()->share('SET',$settings);
            $aid = empty($request->aid) ? 0 : intval($request->aid);

            //categorys
            $categorys = config('book.categorys');
            $share['categorys'] = $categorys;
            $share['CAT'] = $share['catid'] ? $categorys[$share['catid']] : [];

            view()->share($share);
        }
        exit();
    }
}