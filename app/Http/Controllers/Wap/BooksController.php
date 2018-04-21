<?php
/**
 * Note: *
 * User: Liu
 * Date: 2017/3/26
 * Time: 23:47
 */

namespace App\Http\Controllers\Wap;

use App\Http\Controllers\Home\BaseController;

use App\Models\Admin\Book;
use App\Models\Admin\BookDetail;
use App\Models\Admin\BookContent;

use App\Repositories\BookRepository;
use App\Repositories\BookChapterRepository;

use Illuminate\Http\Request;
use DB;

class BooksController extends BaseController
{

    /**
     * 栏目列表
     * @param Request $request
     * @param BookRepository $repository
     * @param $catid
     * @return mixed
     */
    public function getIndex(Request $request, BookRepository $repository, $catid)
    {
        $page = $request->has('page') ? $request->page : 1;

        //封面推荐
        $newLists = \Cache::remember('wap.catid.' . $catid . '.newLists.' . $page, 600, function () use ($repository, $catid) {
            return $repository->ftlists(['catid' => $catid], 'hits DESC', 10, true);
        });

        $data = [
            'newLists' => $newLists
        ];
        return wap_view('book.index', $data);
    }

    /**
     * @param BookRepository $bookRepository
     * @param BookChapterRepository $bookChapterRepository
     * @param $catid
     * @param $id
     * @return mixed
     */
    public function getLists(BookRepository $bookRepository, BookChapterRepository $bookChapterRepository, $catid, $id)
    {
        $book = $bookRepository->find($id);
        $lists = $bookChapterRepository->lists(['pid' => $id], 'chapterid ASC', 5);
        $lastDetail = $bookChapterRepository->lastDetail($id);
        $otherLists = $bookRepository->lists(['catid' => $catid], 'thumb DESC', 9);
        $data = [
            'book' => $book,
            'lists' => $lists,
            'lastDetail' => $lastDetail,
            'otherLists' => $otherLists
        ];
        DB::table('books')->where('id', $id)->increment('hits');
        return wap_view('book.lists', $data);
    }

    /**
     * 章节详情
     * @param BookRepository $bookRepository
     * @param BookChapterRepository $bookChapterRepository
     * @param $catid
     * @param $id
     * @param $aid
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     */
    public function getContent(BookRepository $bookRepository, BookChapterRepository $bookChapterRepository, $catid, $id, $aid)
    {
        $book = $bookRepository->find($id);
        $detail = $bookChapterRepository->find($aid);
        $content = $bookChapterRepository->getContent($detail->pid, $detail->id);
        if (!$content) {
            //$lastDetail = $bookChapterRepository->lastDetail($id);
            //if ($lastDetail) {
            //    return redirect(bookurl($catid, $id, $lastDetail->id));
            //} else {
                abort(404, '该章节已经删除辣, 换个章节看看吧');
            //}
        }
        $detail->content = $content;

        $prevPage = $bookChapterRepository->prevPage($id, $aid);
        $nextPage = $bookChapterRepository->nextPage($id, $aid);

        $otherLists = $bookRepository->lists(['catid' => $catid], '', 3);

        $data = [
            'book' => $book,
            'detail' => $detail,
            'prevPage' => $prevPage,
            'nextPage' => $nextPage,
            'otherLists' => $otherLists
        ];
        DB::table('books')->where('id', $id)->increment('hits');
        DB::table('books_detail')->where('id', $aid)->increment('hits');
        return wap_view('book.content', $data);
    }

    /**
     * 获取最新章节
     * @param BookRepository $bookRepository
     * @param BookChapterRepository $bookChapterRepository
     * @param $catid
     * @param $id
     * @return mixed
     */
    public function getLastContent(BookRepository $bookRepository, BookChapterRepository $bookChapterRepository, $catid, $id)
    {
        $book = $bookRepository->find($id);
        $detail = $bookChapterRepository->lastDetail($id);
        $detail->content = $bookChapterRepository->getContent($detail->pid, $detail->id);

        $prevPage = $bookChapterRepository->prevPage($id, $detail->id);
        $nextPage = $bookChapterRepository->nextPage($id, $detail->id);

        $data = [
            'book' => $book,
            'detail' => $detail,
            'prevPage' => $prevPage,
            'nextPage' => $nextPage,
        ];
        DB::table('books_detail')->where('id', $detail->id)->increment('hits');
        return wap_view('book.content', $data);
    }

    /**
     * 章节列表
     * @param BookRepository $bookRepository
     * @param BookChapterRepository $bookChapterRepository
     * @param $catid
     * @param $id
     * @return mixed
     */
    public function getChapter(BookRepository $bookRepository, BookChapterRepository $bookChapterRepository, $catid, $id)
    {
        $book = $bookRepository->find($id);
        $lists = $bookChapterRepository->lists(['pid' => $id], 'chapterid ASC', 30);
        $data = [
            'book' => $book,
            'lists' => $lists
        ];
        DB::table('books')->where('id', $id)->increment('hits');
        return wap_view('book.chapter', $data);
    }
}