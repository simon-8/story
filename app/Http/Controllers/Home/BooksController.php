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
    public function getIndex(Request $request,Book $bookModel, $catid)
    {
        //封面推荐
        $ftLists = \Cache::remember('catid.' . $catid . '.ftLists' , 600 ,function() use ($bookModel,$catid) {
            return $bookModel->ftlists(['catid' => $catid],'hits DESC',6)->toArray();
        });

        $newLists = $bookModel->lists(['catid' => $catid],'updated_at desc',30);

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
    public function getLists(Request $request,Book $bookModel,BookDetail $bookDetailModel, $catid, $id)
    {
        $book = $bookModel->find($id);
        $lists = $bookDetailModel->lists(['pid' => $id],'chapterid ASC',1000);
        $lastDetail = $bookDetailModel->lastDetail($id);
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
     * @param Book $bookModel
     * @param BookDetail $bookDetailModel
     * @param BookContent $bookContentModel
     * @param $catid
     * @param $id
     * @param $aid
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     */
    public function getContent(Request $request, Book $bookModel, BookDetail $bookDetailModel, BookContent $bookContentModel, $catid, $id, $aid)
    {
        $book = $bookModel->find($id);
        $detail = $bookDetailModel->find($aid);
        $content = $bookContentModel->where('id',$aid)->first();
        if(!$content){
            $lastDetail = $bookDetailModel->lastDetail($id);
            if($lastDetail){
                return redirect(bookurl($catid,$id,$lastDetail->id));
            }
            $content = '';
        }else{
            $content = $content->content;
        }
        $detail->content = $content;

        $prevPage = $bookDetailModel->prevPage($id, $aid);
        $nextPage = $bookDetailModel->nextPage($id, $aid);

        $data = [
            'book'      => $book,
            'detail'    => $detail,
            'prevPage'  => $prevPage,
            'nextPage'  => $nextPage,

        ];
        DB::table('books')->where('id',$id)->increment('hits');
        DB::table('books_detail')->where('id',$aid)->increment('hits');
        return home_view('book.content',$data);
    }


    /**
     * 获取最新章节
     * @param Request $request
     * @param Book $bookModel
     * @param BookDetail $bookDetailModel
     * @param BookContent $bookContentModel
     * @param $catid
     * @param $id
     * @return mixed
     */
    public function getLastContent(Request $request, Book $bookModel, BookDetail $bookDetailModel, BookContent $bookContentModel, $catid, $id)
    {
        $book = $bookModel->find($id);
        $lastDetail = $bookDetailModel->lastDetail($id);
        $content = $bookContentModel->where('id',$lastDetail->id)->first();
        $lastDetail->content = $content->content;

        $prevPage = $bookDetailModel->prevPage($id, $lastDetail->id);
        $nextPage = $bookDetailModel->nextPage($id, $lastDetail->id);

        $data = [
            'book'      => $book,
            'detail'    => $lastDetail,
            'prevPage'  => $prevPage,
            'nextPage'  => $nextPage,

        ];
        DB::table('books_detail')->where('id',$lastDetail->id)->increment('hits');
        return home_view('book.content',$data);
    }
}