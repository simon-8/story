<?php
/**
 * Note: 前台基类控制器
 * User: Liu
 * Date: 2017/3/30
 */
namespace App\Http\Controllers\Home;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Repositories\SettingRepository;

class BaseController extends Controller
{
    public function __construct(Request $request, SettingRepository $settingRepository)
    {
        //通用数据
        if(!\Request::ajax() && \Request::isMethod('get')){

            //System Setting
            $settings = \Cache::remember('settings', 600, function() use ($settingRepository){
                $settings = [];
                foreach($settingRepository->lists() as $v){
                    $settings[$v['item']] = $v['value'];
                }
                return $settings;
            });

            view()->share('SET',$settings);

            //Normal param

            $catid = empty($request->catid) ? 0 : intval($request->catid);
            view()->share('catid',$catid);
            $id = empty($request->id) ? 0 : intval($request->id);
            view()->share('id',$id);
            $aid = empty($request->aid) ? 0 : intval($request->aid);
            view()->share('aid',$aid);

            //categorys
            $categorys = config('book.categorys');
            view()->share('categorys',$categorys);
            view()->share('CAT',$catid ? $categorys[$catid] : []);
        }
    }
}