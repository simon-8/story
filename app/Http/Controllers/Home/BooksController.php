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
use DB;
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
        $ftLists = $book->lists(['catid' => $catid],'',6,false);
        $newLists = $book->lists(['catid' => $catid],'updated_at desc',30);
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
        $lists = $bookDetail->lists(['pid' => $id],'id ASC',500);
        $lastDetail = $bookDetail->lastDetail($id);
        $data = [
            'book'      => $book,
            'lists'     => $lists,
            'lastDetail' => $lastDetail,
        ];
        DB::table('books')->where('id',$id)->increment('hits');
        return home_view('book.lists',$data);
    }


    /**
     * 章节详情
     * @param Request $request
     * @param Book $book
     * @param BookDetail $bookDetail
     * @param BookContent $bookContent
     * @param $catid
     * @param $id
     * @param $aid
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     */
    public function getContent(Request $request, Book $book, BookDetail $bookDetail, BookContent $bookContent, $catid, $id, $aid)
    {
        $book = $book->find($id);
        $detail = $bookDetail->find($aid);
        $content = $bookContent->where('id',$aid)->first();
        if(!$content){
            $lastDetail = $bookDetail->lastDetail($id);
            return redirect(bookurl($catid,$id,$lastDetail->id));
        }
        $detail->content = $content->content;

        $prevPage = $bookDetail->prevPage($id, $aid);
        $nextPage = $bookDetail->nextPage($id, $aid);

        $data = [
            'book'      => $book,
            'detail'    => $detail,
            'prevPage'  => $prevPage,
            'nextPage'  => $nextPage,

        ];
        DB::table('books_detail')->where('id',$aid)->increment('hits');
        return home_view('book.content',$data);
    }

    /**
     * 获取最新章节
     * @param Request $request
     * @param Book $book
     * @param BookDetail $bookDetail
     * @param BookContent $bookContent
     * @param $catid
     * @param $id
     */
    public function getLastContent(Request $request, Book $book, BookDetail $bookDetail, BookContent $bookContent, $catid, $id)
    {
        $book = $book->find($id);
        $lastDetail = $bookDetail->lastDetail($id);
        $content = $bookContent->where('id',$lastDetail->id)->first();
        $lastDetail->content = $content->content;

        $prevPage = $bookDetail->prevPage($id, $lastDetail->id);
        $nextPage = $bookDetail->nextPage($id, $lastDetail->id);

        $data = [
            'book'      => $book,
            'detail'    => $lastDetail,
            'prevPage'  => $prevPage,
            'nextPage'  => $nextPage,

        ];
        return home_view('book.content',$data);
    }
}