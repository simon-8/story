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
use QL\QueryList;

use DB;
use App\Jobs\ArtCaiJi;
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

    public function getCreate()
    {
        dd(base_path('config'));
    }

    public function postCreate()
    {

    }

    /**
     * 更新文章资料
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postUpdate(Request $request)
    {
        $result = $this->model->updateBook($request->all());
        if($result)
        {
            return redirect()->route('Book.getIndex')->with('Message','修改成功');
        }
        else
        {
            return back()->withErrors('修改失败')->withInput();
        }
    }

    /**
     * 删除对应文章
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDelete(Request $request)
    {
        $result = $this->model->deleteBook($request->id);
        if($result)
        {
            return redirect()->route('Book.getIndex')->with('Message','删除成功');
        }
        else
        {
            return back()->withErrors('删除失败')->withInput();
        }
    }

    //回收站
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
        return config('book.categorys');
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

    /**
     * 获取章节内容
     * @param Request $request
     * @param BookDetail $bookDetail
     * @return mixed
     */
    public function getDetail(Request $request , BookDetail $bookDetail)
    {
        return $bookDetail->find($request->id);
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

    /**
     * 加入任务队列
     * @param Request $request
     * @return mixed
     */
    public function getCreateQueue(Request $request)
    {
        $data = $request->all();
        $source = $data['source'];
        return $this->$source($data);
    }

    protected function dushu88($data)
    {

        $baseUrl = 'http://www.8dushu.com';

        $catid = $data['catid'];

        $pagesize = 31;
        $totalPage = ceil($data['number'] / $pagesize);//需要采集的总页码

        $rules = config('book.rules.88dushu.lists');

        $SuccessCount = 0;
        for($page = 1;$page <= $totalPage;$page++)
        {
            $url = $baseUrl . '/sort'.$catid.'/'.$page.'/';
            $result = QueryList::Query($url,$rules,'','UTF-8','GBK',true)->getData();

            foreach($result as &$v){

                if($SuccessCount >= $data['number']){
                    break;
                }

                if( !empty($v['linkurl']) ){
                    $v['linkurl'] = $baseUrl . $v['linkurl'];
                }
                $v['wordcount'] = preg_replace('/[^0-9]+/','',$v['wordcount']);

                if( !empty($v['title']) ){

                    $item = DB::table('books')->where('title',trim($v['title']))->first();

                    if($item){

                        DB::table('books')->where('id',$item->id)->update([
                            'wordcount' => $v['wordcount'],
                            'zhangjie'  => $v['zhangjie'],
                        ]);
                        $v['id'] = $item->id;

                    }else{

                        $id = DB::table('books')->insertGetId([
                            'catid' => $catid,
                            'title' => $v['title'],
                            'introduce' => '',
                            'zhangjie'  => $v['zhangjie'],
                            'author'=> $v['author'],
                            'wordcount' => $v['wordcount'],
                            'follow'    => 0,
                            'hits'      => 0,
                            'status'    => 1,
                            'created_at'=> date('Y-m-d H:i:s'),
                            'updated_at'=> date('Y-m-d H:i:s'),
                        ]);
                        $v['id'] = $id;

                    }

                    //推送到任务队列
                    $this->dispatch(new ArtCaiJi($v));
                    $SuccessCount++;
                }
            }
        }

        \File::put( public_path().'/caiji/data.php' , '<?php return ' . var_export($data,true) .';?>' );

        return redirect()->route('Book.getIndex')->with('Message','操作成功');
    }

    public function getQueueNumber()
    {
        return DB::table('jobs')->count();
    }

}