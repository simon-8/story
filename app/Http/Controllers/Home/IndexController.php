<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/1/9
 * Time: 14:00
 */
namespace App\Http\Controllers\Home;
use App\Http\Controllers\Controller;

use DB;

use App\Models\Admin\Book;

class IndexController extends Controller
{
    public function getIndex(Book $book)
    {
        $categorys = config('book.categorys');
        $lists = $book->lists();
        $data = [
            'categorys' => $categorys,
            'lists' => $lists,
        ];
        return home_view('index.index',$data);
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