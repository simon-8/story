<?php
/**
 * Note: 小说管理
 * User: Liu
 * Date: 2017/3/13
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Admin\Book;
use App\Models\Admin\BookContent;
use App\Models\Admin\BookDetail;
use Illuminate\Http\Request;
use QL\QueryList;

use DB;
use App\Jobs\ArtCaiJi;
use App\Jobs\ArticleDetail;
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
     * 更新指定文章章节
     * @param Request $request
     * @param Book $book
     * @return bool
     */
    public function getDtailListsUpdate(Request $request, Book $book)
    {
        $id = $request->id;
        $number = intval($request->number) < 1 ? 10 : intval($request->number);
        $data = $book->find($id);

        //获取章节列表
        $rules = [
            'title' => [
                '.mulu li a' , 'text'
            ],
            'linkurl' => [
                '.mulu li a' , 'href'
            ],
        ];
        $result = QueryList::Query($data->fromurl,$rules,'','UTF-8','GBK',true)->getData();

        $count = 0;
        foreach($result as $v)
        {
            $v = array_map('trim',$v);
            if(!empty($v['linkurl'])){

                $v['linkurl'] = substr($v['linkurl'],0,4) != 'http' ? $data->fromurl . $v['linkurl'] : $v['linkurl'];

                $detail = DB::table('books_detail')->select('id')->where('fromhash',md5($v['linkurl']))->where('pid',$data->id)->first();
                if( $detail ){
                    //\Log::debug('-------> 该章节已采集过，跳过此节 -------> ' . $this->Book['title'] . '  章节: ' . $v['title']);
                }else{
                    if($count > $number){
                        break;
                    }
                    //推送到章节采集队列
                    dispatch(
                        new ArticleDetail( array_merge($v,['pid' => $data->id]) )
                    );
                    $count++;
                }
            }
        }
        return 1;
    }

    /**
     * 获取章节内容
     * @param Request $request
     * @param BookContent $bookContent
     * @return string
     */
    public function getDetail(Request $request , BookContent $bookContent)
    {
        return $bookContent->getContent($request->id);
    }


    /**
     * 更新指定章节
     * @param Request $request
     * @param BookDetail $bookDetail
     * @param BookContent $bookContent
     * @return mixed
     */
    public function getUpdateDetail(Request $request , BookDetail $bookDetail , BookContent $bookContent)
    {
        $item = $bookDetail->find($request->id);
        $item->content = $bookContent->getContent($request->id);
        return admin_view('book.create_detail',$item);
    }


    /**
     * 更新指定章节
     * @param Request $request
     * @param BookDetail $bookDetail
     * @param BookContent $bookContent
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postUpdateDetail(Request $request , BookDetail $bookDetail , BookContent $bookContent)
    {
        $data = $request->all();
        $result = $bookDetail->updateDetail($data);
        if($result)
        {
            $bookContent->updateContent($data);
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
     * @param BookContent $bookContent
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDeleteDetail(Request $request , BookDetail $bookDetail , BookContent $bookContent)
    {
        $result = $bookDetail->destroy($request->id);
        if($result)
        {
            $bookContent->where('id',$request->id)->delete();
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

    /*
     * 1.读取待采集栏目页面所有指定链接
     * 2.对链接进行补全，得到完整链接
     * 3.将该链接放入数据库中查询,判断是否存在记录
     *
     * */
    protected function dushu88($data)
    {

        $baseUrl = 'http://www.8dushu.com';

        $catid = $data['catid'];

        $pagesize = 31;
        $totalPage = ceil($data['number'] / $pagesize);//需要采集的总页码

        $rules = config('book.rules.88dushu.lists');//列表页采集规则

        $SuccessCount = 0;
        for($page = 1;$page <= $totalPage;$page++)
        {
            $url = $baseUrl . '/sort'.$catid.'/'.$page.'/';
            $result = QueryList::Query($url,$rules,'','UTF-8','GBK',true)->getData();

            foreach($result as &$v){
                $v = array_map('trim',$v);//移除所有字段空格

                if($SuccessCount >= $data['number']){
                    break;
                }

                if( !empty($v['linkurl']) ){
                    if(substr($v['linkurl'],0,4) !== 'http') $v['linkurl'] = $baseUrl . $v['linkurl'];
                }else{
                    continue;
                }
                $v['wordcount'] = preg_replace('/[^0-9]+/','',$v['wordcount']);

                if( !empty($v['title']) ){
                    //1062 Duplicate entry

                    $item = DB::table('books')->where('fromhash',md5(trim($v['linkurl'])))->first();//根据unique索引检查数据是否存在

                    if($item){
                        //DB::table('books')->where('id',$item->id)->update([
                        //    'wordcount' => $v['wordcount'],
                        //    'zhangjie'  => $v['zhangjie'],
                        //]);
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
                            'fromurl'   => $v['linkurl'],
                            'fromhash'  => md5($v['linkurl']),
                            'created_at'=> date('Y-m-d H:i:s'),
                            'updated_at'=> date('Y-m-d H:i:s'),
                        ]);
                        $v['id'] = $id;
                    }

                    $this->dispatch(new ArtCaiJi($v));//推送到任务队列
                    $SuccessCount++;
                }
            }
        }

        /*\File::put( public_path().'/caiji/data.php' , '<?php return ' . var_export($data,true) .';?>' );*/

        return redirect()->route('Book.getIndex')->with('Message','操作成功');
    }

    public function getQueueNumber()
    {
        return DB::table('jobs')->count();
    }

}