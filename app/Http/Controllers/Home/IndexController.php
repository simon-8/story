<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/1/9
 * Time: 14:00
 */
namespace App\Http\Controllers\Home;
use App\Http\Controllers\Controller;
use App\Jobs\ArtCaiJi;
use QL\QueryList;
use DB;
class IndexController extends Controller
{
    public function getIndex()
    {
        return home_view('index.index');
    }

    public function getQueue()
    {

    }


    public function getEdit()
    {
        echo date('Y-m-d H:i:s');
    }

    public function getTest()
    {
        $lists = DB::select('SELECT pid,fromurl FROM books');
    }

}