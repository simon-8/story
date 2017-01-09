<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/1/9
 * Time: 14:00
 */
namespace App\Http\Controllers\Home;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function getIndex()
    {
        $email = 'www.614895458.xsf@qq.com';
        return home_view('index.index');
    }


    public function getEdit()
    {
        echo 'this is edit';
    }
}