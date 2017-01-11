<?php
/**
 * Created by PhpStorm.
 * User: Simon
 * Date: 2016/11/27
 * Time: 23:36
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
class IndexController extends Controller
{

    public function getIndex()
    {
        return view('admin.index');
    }

}