<?php
/**
 * Note: *
 * User: Liu
 * Date: 2017/3/26
 * Time: 23:47
 */

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;

use App\Repositories\BookRepository;
use App\Repositories\BookChapterRepository;

use DB;

class BooksController extends BaseController
{

    /**
     * 栏目列表
     * @param BookRepository $repository
     * @param $catid
     * @return mixed
     */
    public function getIndex(BookRepository $repository, $catid)
    {
        //封面推荐
        $ftLists = \Cache::remember('catid.' . $catid . '.ftLists', 600, function () use ($repository, $catid) {
            return $repository->ftlists(['catid' => $catid], 'hits DESC', 6)->toArray();
        });

        $newLists = $repository->lists(['catid' => $catid], 'updated_at desc', 30);

        $data = ['ftLists' => $ftLists, 'newLists' => $newLists,];
        return home_view('book.index', $data);
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
        $lists = $bookChapterRepository->lists(['pid' => $id], 'chapterid ASC', 1000);
        $lastDetail = $bookChapterRepository->lastDetail($id);
        $data = ['book' => $book, 'lists' => $lists, 'lastDetail' => $lastDetail,];
        DB::table('books')->where('id', $id)->increment('hits');
        return home_view('book.lists', $data);
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
        $content = $bookChapterRepository->getContent($detail->pid, $detail->chapterid);
        if (!$content) {
            $lastDetail = $bookChapterRepository->lastDetail($id);
            if ($lastDetail) {
                return redirect(bookurl($catid, $id, $lastDetail->id));
            } else {
                abort(404, '该章节已经删除辣, 换个章节看看吧');
            }
        }
        $detail->content = $content;

        $prevPage = $bookChapterRepository->prevPage($id, $aid);
        $nextPage = $bookChapterRepository->nextPage($id, $aid);

        $data = [
            'book' => $book,
            'detail' => $detail,
            'prevPage' => $prevPage,
            'nextPage' => $nextPage,
        ];
        DB::table('books')->where('id', $id)->increment('hits');
        DB::table('books_detail')->where('id', $aid)->increment('hits');
        return home_view('book.content', $data);
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
        if (!$detail) {
            abort(404, '该章节已经删除辣, 换个章节看看吧');
        }
        $detail->content = $bookChapterRepository->getContent($detail->pid, $detail->chapterid);
        $prevPage = $bookChapterRepository->prevPage($id, $detail->id);
        $nextPage = $bookChapterRepository->nextPage($id, $detail->id);

        $data = [
            'book' => $book,
            'detail' => $detail,
            'prevPage' => $prevPage,
            'nextPage' => $nextPage
        ];
        DB::table('books_detail')->where('id', $detail->id)->increment('hits');
        return home_view('book.content', $data);
    }
}