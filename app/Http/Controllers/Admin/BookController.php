<?php
/**
 * Note: 小说管理
 * User: Liu
 * Date: 2017/3/13
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Admin\Book;
use App\Models\Admin\BookDetail;
use Illuminate\Http\Request;

class BookController extends BaseController
{
    protected $model;

    public function __construct(Book $book)
    {
        parent::__construct();
        $this->model = $book;
    }

    /**
     * 首页
     * @return mixed
     */
    public function getIndex()
    {
        $lists = $this->model->lists();
        $categorys = $this->Categorys();
        $data = [
            'lists' => $lists,
            'categorys' => $categorys,
        ];
        return admin_view('book.index',$data);
    }

    /**
     * 获取章节列表
     * @param Request $request
     * @param BookDetail $bookDetail
     * @return mixed
     */
    public function getDetailLists(Request $request, BookDetail $bookDetail)
    {
        $lists = $bookDetail->lists(['pid' => $request->id],'id DSEC',10);
        return $lists;
    }

    public function getDetail(Request $request ,BookDetail $bookDetail)
    {
        return $bookDetail->find($request->id);
    }

    public function getCreate()
    {
        dd(base_path('config'));
    }

    public function postCreate()
    {

    }

    public function getUpdate()
    {

    }

    public function postUpdate()
    {

    }

    public function getDelete()
    {

    }

    public function getRecycle()
    {

    }

    /**
     * 栏目分类
     * @return mixed
     */
    public function getCategorys()
    {
        $lists = $this->Categorys();
        $data = [
            'lists' => $lists,
        ];
        return admin_view('book.categorys',$data);
    }

    /**
     * 获取栏目
     * @return array
     */
    public function Categorys()
    {
        return  [
            1 => [
                'id' => 1,
                'pid'=> 0,
                'listorder' => 0,
                'items' => 0,
                'name' => '玄幻魔法',
            ],
            2 => [
                'id' => 2,
                'pid'=> 0,
                'listorder' => 0,
                'items' => 0,
                'name' => '武侠修真',
            ],
            3 => [
                'id' => 3,
                'pid'=> 0,
                'listorder' => 0,
                'items' => 0,
                'name' => '都市言情',
            ],
            4 => [
                'id' => 4,
                'pid'=> 0,
                'listorder' => 0,
                'items' => 0,
                'name' => '历史穿越',
            ],
            5 => [
                'id' => 5,
                'pid'=> 0,
                'listorder' => 0,
                'items' => 0,
                'name' => '恐怖悬疑',
            ],
            6 => [
                'id' => 6,
                'pid'=> 0,
                'listorder' => 0,
                'items' => 0,
                'name' => '游戏竞技',
            ],
            7 => [
                'id' => 7,
                'pid'=> 0,
                'listorder' => 0,
                'items' => 0,
                'name' => '军事科幻',
            ],
            8 => [
                'id' => 8,
                'pid'=> 0,
                'listorder' => 0,
                'items' => 0,
                'name' => '综合类型',
            ],
            9 => [
                'id' => 9,
                'pid'=> 0,
                'listorder' => 0,
                'items' => 0,
                'name' => '女生频道',
            ],
        ];
    }


    /**
     * 更新指定章节
     * @param Request $request
     * @param BookDetail $bookDetail
     * @return mixed
     */
    public function getUpdateDetail(Request $request , BookDetail $bookDetail)
    {
        $item = $bookDetail->find($request->id);
        return admin_view('book.create_detail',$item);
    }

    /**
     * 更新指定章节
     * @param Request $request
     * @param BookDetail $bookDetail
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postUpdateDetail(Request $request , BookDetail $bookDetail)
    {
        $result = $bookDetail->updateDetail($request->all());
        if($result)
        {
            return redirect()->route('Book.getIndex')->with('Message','修改成功');
        }
        else
        {
            return back()->withErrors('更新失败')->withInput();
        }
    }

    /**
     * 删除指定章节
     * @param Request $request
     * @param BookDetail $bookDetail
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDeleteDetail(Request $request , BookDetail $bookDetail)
    {
        $result = $bookDetail->destroy($request->id);
        if($result)
        {
            return redirect()->route('Book.getIndex')->with('Message','删除成功');
        }
        else
        {
            return back()->withErrors('删除失败')->withInput();
        }
    }

}