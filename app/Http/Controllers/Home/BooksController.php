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

class BooksController extends BaseController
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
            'ftLists'    => $ftLists,
            'newLists'   => $newLists,
        ];
        return home_view('book.index',$data);
    }

    /**
     *
     * @param Request $request
     * @param $catid
     * @param $id
     * @return mixed
     */
    public function getLists(Request $request,Book $book,BookDetail $bookDetail, $catid, $id)
    {
        $book = $book->find($id);
        $lists = $bookDetail->lists(['pid' => $id],'',500);
        $lastDetail = $bookDetail->lastDetail($id);
        $data = [
            'book'      => $book,
            'lists'     => $lists,
            'lastDetail' => $lastDetail,
        ];
        return home_view('book.lists',$data);
    }



    public function getContent(Request $request,Book $book,BookDetail $bookDetail,BookContent $bookContent,$catid, $id,$aid)
    {
        $book = $book->find($id);
        $detail = $bookDetail->find($aid);
        $content = $bookContent->where('id',$aid)->first();
        $detail->content = $content->content;

        $prevPage = $bookDetail->prevPage($id, $aid);
        $nextPage = $bookDetail->nextPage($id, $aid);

        $data = [
            'book'      => $book,
            'detail'    => $detail,
            'prevPage'  => $prevPage,
            'nextPage'  => $nextPage,

        ];
        return home_view('book.content',$data);
    }
}