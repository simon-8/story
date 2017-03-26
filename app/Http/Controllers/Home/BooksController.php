<?php
/**
 * Note: *
 * User: Liu
 * Date: 2017/3/26
 * Time: 23:47
 */
namespace App\Http\Controllers\Home;
use App\Http\Controllers\Controller;

use App\Models\Admin\Book;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    protected $model;
    public function __construct()
    {
        $this->model = new Book();
    }

    public function getIndex(Request $request)
    {
        //var_dump($request->id);
        //$lists = $this->model->lists(['catid' => $catid]);

        $categorys = config('book.categorys');

        $data = [
            'categorys' => $categorys,

        ];
        return home_view('book.index',$data);
    }

    public function getLists()
    {
        return home_view('book.lists');
    }

    public function getBlists()
    {
        return home_view('book.blists');
    }

    public function getContent()
    {
        return home_view('book.content');
    }
}