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
use App\Models\Admin\BookDetail;
use App\Models\Admin\BookContent;
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
    public function getLists(Request $request,Book $book,BookDetail $bookDetail, $catid, $id)
    {
        $categorys = config('book.categorys');
        $book = $book->find($id);
        $lists = $bookDetail->lists(['pid' => $id],'',500);
        $data = [
            'CAT'       => $categorys[$catid],
            'categorys' => $categorys,
            'book'      => $book,
            'lists'     => $lists,
        ];
        return home_view('book.lists',$data);
    }

//    public function getBlists()
//    {
//        return home_view('book.blists');
//    }









    public function getContent(Request $request,Book $book,BookContent $bookContent,$catid, $id,$aid)
    {
        $book = $book->find($id);
        $content = $bookContent->where('id',$aid)->first();
        return home_view('book.content',array_merge($book,['content' => $content->content]));
    }
}