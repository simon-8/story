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
    /**
     * 栏目列表
     * @param Request $request
     * @param $catid
     * @return mixed
     */
    public function getIndex(Request $request,Book $book, $catid)
    {
        $categorys = config('book.categorys');

        $ftLists = $book->lists(['catid' => $catid],'',6,false);
        $newLists = $book->lists(['catid' => $catid],'updated_at desc',50);
        $data = [
            'CAT'       => $categorys[$catid],
            'categorys' => $categorys,
            'ftLists'    => $ftLists,
            'newLists'   => $newLists,
        ];
        return home_view('book.index',$data);
    }

    /**
     * 章节
     * @param Request $request
     * @param $catid
     * @param $id
     * @return mixed
     */
    public function getLists(Request $request, $catid, $id)
    {
        $categorys = config('book.categorys');
        $data = [
            'categorys' => $categorys,
        ];
        return home_view('book.lists',$data);
    }

//    public function getBlists()
//    {
//        return home_view('book.blists');
//    }

    public function getContent()
    {
        return home_view('book.content');
    }
}