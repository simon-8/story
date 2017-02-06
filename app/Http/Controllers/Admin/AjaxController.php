<?php
/**
 * Note: Ajax集中处理
 * User: Liu
 * Date: 2017/2/6
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AjaxController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getIndex(Request $request)
    {
        $ac = $request->ac;
        switch ($ac){
            case 'thumb':
                return admin_view('ajax.'.$ac , $request->all());
                break;
            case 'choose_thumb'://缩略图文件夹
                $data = $request->all();
                $filepath = public_path().'/uploads/thumbs/';
                $folder = scandir($filepath);
                array_shift($folder);
                array_shift($folder);
                $data['folder'] = $folder;
                return admin_view('ajax.'.$ac , $data);
                break;
            case 'choose_thumb_detail'://文件夹内图片列表
                $name = $request->name;
                $filepath = public_path().'/uploads/thumbs/'.$name.'/';
                if(is_dir($filepath)){
                    $files = scandir($filepath);
                    array_shift($files);
                    array_shift($files);
                    foreach($files as $v){
                        $images[] = str_replace(public_path(),url('/'),$filepath.$v);
                    }
                    $data = $request->all();
                    $data['images'] = $images;
                    return admin_view('ajax.choose_thumb' , $data);
                }
                break;
            case 'tagcloud'://输出所有标签
                $res['code'] = 1;
                $res['msg'] = '';
                break;
        }
    }
}