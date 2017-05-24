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
/*        $book = DB::table('books')->select('id')->get();
        foreach($book as $v){
            $title = DB::table('books_detail')->select('title')->where('pid',$v->id)->orderBy('id','desc')->first();
            if($title){
                DB::table('books')->where('id',$v->id)->update(['zhangjie' => $title->title]);
            }
        }
        exit();*/
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
     * 更新指定数量小说
     * @param Request $request
     * @param Book $book
     * @return int
     */
    public function postDetailUpdate(Request $request, Book $book)
    {
        $type = $request->updateType;
        $number = intval($request->number) < 1 ? 10 : abs(intval($request->number));
        $zhangjieNumber = intval($request->zhangjieNumber) < 1 ? 50 : abs(intval($request->zhangjieNumber));

        $lists = [];
        if($type == 1){//指定栏目

            $catids = $request->catid;
            $lists = DB::table('books')
                        ->whereIn('catid',$catids)
                        ->orderBy('updated_at','asc')
                        ->take($number)
                        ->get();

        }else if($type == 2){//指定范围

            $startId = (int) $request->startId;
            $endId = $request->has('endId') ? $request->endId : $startId+100;

            $lists = DB::table('books')
                ->whereBetween('id',[$startId , $endId])
                ->orderBy('updated_at','asc')
                ->take($number)
                ->get();

        }else if($type == 3){//指定文章

            $targetId = $request->targetId;
            $lists = DB::table('books')->where('id',$targetId)->get();

        }else if($type == 4){//修复空白数据

            $ids = DB::table('books_content')->where('content','')->orderBy('id','asc')->take($zhangjieNumber)->lists('id');
            $lists = DB::table('books_detail')->whereIn('id' , $ids)->get();
            $rules = [
                'content' => [
                    '.yd_text2','html'
                ]
            ];
            $contentTotal = 0;

            foreach($lists as $v){
                $html = QueryList::Query($v['fromurl'] , $rules , '' ,'UTF-8','GBK',true)->getData();
                $result = array_shift($html);
                if(!empty($result['content'])){
                    DB::table('books_content')->where('id',$v['id'])->update([
                        'content' => $result['content']
                    ]);
                    $contentTotal++;
                }
            }
            $zhangjieCount = count($lists);
            $successPercent = sprintf('%.2f',$contentTotal/$zhangjieCount)*100;
            return redirect()->route('Book.getIndex')->with('Message','成功恢复 ' . $contentTotal . ' 章节，成功率 ' . $successPercent . ' %');
        }

        $sourceLists = array_keys($book::sourceLists(1));
        $successCount = 0;
        foreach($lists as $v)
        {
            if(in_array($v['source'] , $sourceLists))
            {
                $successCount++;
                $ClassName = '\App\Jobs\Books\\'.ucfirst($v['source']) . 'Chapter';
                $this->dispatch(new $ClassName($v,$zhangjieNumber));
            }

        }
        return redirect()->route('Book.getIndex')->with('Message','操作成功，共更新 ' . $successCount . '本');
    }

    /**
     * 采集指定文章章节
     * @param Request $request
     * @param Book $book
     * @return bool
     */
    public function getDetailListsUpdate(Request $request, Book $book)
    {
        $id = $request->id;
        $number = intval($request->number);
        $data = $book->find($id);
        $ClassName = '\App\Jobs\Books\\'.ucfirst($data['source']) . 'Chapter';
        $this->dispatch(new $ClassName($data,$number));
        return 1;
    }

    protected function dushu88Detail($data,$number)
    {
        $this->dispatch(new ArtCaiJi($data,$number));
        return true;
    }

    /**
     * 获取最新章节信息
     * @param $pid
     * @return mixed
     */
    protected function getLastArticle($pid)
    {
        return DB::table('books_detail')->select('id','chapterid','title','fromhash')->where('pid',$pid)->orderBy('chapterid','desc')->first();
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

        $catids = [];
        if(empty($data['catid'])){
            $categorys = config('book.categorys');
            foreach($categorys as $v){
                $catids[] = $v['id'];
            }
        }else{
            $catids = $data['catid'];
        }

        $pagesize = 31;
        $data['number'] = intval($data['number']) < 1 ? 10 : intval($data['number']);
        $data['zhangjieNumber'] = intval($data['zhangjieNumber']) < 1 ? 10 : intval($data['zhangjieNumber']);
        //$totalNumber = count($catids) * $data['number'];
        $rules = config('book.rules.88dushu.lists');//列表页采集规则

        $SuccessCount = 0;

        foreach($catids as $catid){

            $totalPage = ceil($data['number'] / $pagesize);//需要采集的总页码
            $catCount = 0;
            for($page = 1;$page <= $totalPage;$page++)
            {
                $url = $baseUrl . '/sort'.$catid.'/'.$page.'/';
                $result = QueryList::Query($url,$rules,'.booklist>ul>li','UTF-8','GBK',true)->getData();
                array_shift($result);//移除第一行

                if($page == $totalPage){
                    $result = array_slice($result, 0 , $data['number'] - $catCount);//最后一页截取指定剩余数量
                }

                foreach($result as &$v){
                    $v = array_map('trim',$v);//移除所有字段空格

                    if($catCount >= $data['number']){//当前分类已采集完毕
                        break;
                    }

                    //已采集总数         应采集总数
                    //if($SuccessCount >= $totalNumber){
                    //    break 2;
                    //}

                    if( !empty($v['fromurl']) ){
                        if(substr($v['fromurl'],0,4) !== 'http') $v['fromurl'] = $baseUrl . $v['fromurl'];
                    }else{
                        continue;
                    }

                    if( !empty($v['title']) ){
                        //1062 Duplicate entry

                        $item = DB::table('books')->where('fromhash',md5(trim($v['fromurl'])))->first();//根据unique索引检查数据是否存在

                        if($item){
                            $v = $item;//推送到任务队列
                        }else{
                            $v['wordcount'] = preg_replace('/[^0-9]+/','',$v['wordcount']);
                            $v = [
                                'catid' => $catid,
                                'title' => $v['title'],
                                'introduce' => '',
                                'zhangjie'  => $v['zhangjie'],
                                'author'=> $v['author'],
                                'wordcount' => $v['wordcount'],
                                'follow'    => 0,
                                'hits'      => 0,
                                'status'    => 1,
                                'fromurl'   => $v['fromurl'],
                                'fromhash'  => md5($v['fromurl']),
                                'created_at'=> date('Y-m-d H:i:s'),
                                'updated_at'=> date('Y-m-d H:i:s'),
                            ];
                            $id = DB::table('books')->insertGetId($v);
                            $v['id'] = $id;
                        }
                        $this->dispatch(new ArtCaiJi($v,$data['zhangjieNumber']));//推送到任务队列
                        $catCount++;
                        $SuccessCount++;
                    }
                }
            }
        }

        /*\File::put( public_path().'/caiji/data.php' , '<?php return ' . var_export($data,true) .';?>' );*/

        return redirect()->route('Book.getIndex')->with('Message','操作成功');
    }


    /**
     * 1.读取待采集栏目页面所有指定链接
     * 2.对链接进行补全，得到完整链接
     * 3.将该链接放入数据库中查询,判断是否存在记录
     * 75小说源
     * @param $data
     * @return \Illuminate\Http\RedirectResponse
     */
    public function wx999($data)
    {
        $config = config('books.' . __FUNCTION__);

        $baseUrl         = $config['baseUrl'];
        $customCategorys = $config['categorys'];//分类对应
        $listsRules      = $config['lists'];//列表页配置
        $detailListRules = $config['detail_list'];//章节页配置
        //$contentRules = $config['content'];//内容页配置
        $pagesize        = $listsRules['pagesize'];//列表页文章数量
        $rules           = $listsRules['rules'];//列表页采集规则
        $pageurl         = $listsRules['pageurl'];//列表页地址
        $charset         = $config['charset'];//编码
        $catids          = [];
        if(empty($data['catid'])){
            $categorys = config('book.categorys');
            foreach($categorys as $v){
                $catids[] = $v['id'];
            }
        }else{
            $catids = $data['catid'];
        }


        $data['number'] = intval($data['number']) < 1 ? 10 : intval($data['number']);
        $data['zhangjieNumber'] = intval($data['zhangjieNumber']);
        $SuccessCount = 0;

        foreach($catids as $catid){
            $customCatid = $customCategorys[$catid];//对应分类ID
            $totalPage = ceil($data['number'] / $pagesize);//需要采集的总页码
            $catCount = 0;
            for($page = 1;$page <= $totalPage;$page++) {

                $url = $baseUrl . sprintf($pageurl, $customCatid, $page);

                $html = request_spider($url);
                $response = QueryList::Query($html, $rules, $listsRules['range'], 'UTF-8', $charset, true)->getData();

                //过滤无效数据
                $result = array_filter($response, function ($v) {
                    if (!empty($v['title']) && !empty($v['fromurl'])) return true;
                });

                if ($page == $totalPage) {
                    $result = array_slice($result, 0, $data['number'] - $catCount);//最后一页截取指定剩余数量
                }

                foreach ($result as &$v) {
                    $v = array_map('trim', $v);//移除所有字段空格

                    if ($catCount >= $data['number']) {//当前分类已采集完毕
                        break;
                    }

                    //组成列表页链接
                    if (substr($v['fromurl'], 0, 4) !== 'http') {
                        $v['fromurl'] = $baseUrl . substr($v['fromurl'], 1);
                    }
                    $targetId = str_replace([$baseUrl . 'Book/' , '.aspx'] , '' , $v['fromurl']);
                    $v['fromurl'] = $baseUrl . sprintf($detailListRules['pageurl'] , $customCatid , $targetId);

                    //1062 Duplicate entry
                    $item = DB::table('books')->where('fromhash', md5(trim($v['fromurl'])))->first();//根据unique索引检查数据是否存在

                    if ($item) {
                        $v = $item;//推送到任务队列
                    } else {
                        $v = [
                            'catid' => $catid,
                            'title' => $v['title'],
                            'introduce' => '',
                            'zhangjie' => $v['zhangjie'],
                            'author' => $v['author'],
                            'wordcount' => 0,
                            'follow' => 0,
                            'hits' => 0,
                            'status' => 1,
                            'fromurl' => $v['fromurl'],
                            'fromhash' => md5($v['fromurl']),
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        ];
                        $id = DB::table('books')->insertGetId($v);
                        $v['id'] = $id;
                    }
                    $v['catid'] = $customCatid;
                    $this->dispatch(new \App\Jobs\Books\Wx999Chapter($v, $data['zhangjieNumber']));//推送到任务队列
                    $catCount++;
                    $SuccessCount++;
                }
            }
        }

        return redirect()->route('Book.getIndex')->with('Message','操作成功');
    }

    /**
     * 获取当前队列数量
     * @return int
     */
    public function getQueueNumber()
    {
        if(config('queue.default') == 'database'){
            return DB::table('jobs')->count();
        }else{
            return 0;
        }
    }

}