<?php
/*
 * 抓取任务列表
 * */
namespace App\Jobs\Books;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

use QL\QueryList;
use DB;
use App\Jobs\Books\Wx999Content;
class Wx999Chapter extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $Book; //[id,formurl]
    protected $Count;
    public function __construct($Book , $Count = 0)
    {
        $this->Book = $Book;
        $this->Count = $Count;
    }

    /**
     * Execute the job.
     *
     * @return mixed
     */
    public function handle()
    {
        if( empty($this->Book['fromurl']) || empty($this->Book['id'])){
            logwrite(' --- 采集失败，Book DATA ---' . var_export($this->Book , true));
            return true;
        }
        $config = config('books.wx999');
        try{

            //更新文章详情 / 缩略图
            if( empty($this->Book['introduce']) || empty($this->Book['thumb']) ){
                $rules = [
                    'introduce' => [
                        '.sc+p' , 'text'
                    ],
                    'wordcount' => [
                        '#box4 p small' , 'text'
                    ],
                    'thumb' => [
                        '.wleft img' , 'src'
                    ]
                ];

                $indexUrl = $this->getIndexUrl($config['baseUrl'] , $this->Book['fromurl']);
                $html = request_spider($indexUrl);
                $bookInfo = QueryList::Query($html , $rules , '' ,'UTF-8','GBK',true)->getData();

                $updateData = [];
                if(empty($this->Book['introduce']) && !empty($bookInfo[0]['introduce'])){
                    $updateData['introduce'] = $bookInfo[0]['introduce'];
                }

                if(empty($this->Book['wordcount']) && !empty($bookInfo[0]['wordcount'])){
                    $updateData['wordcount'] = $bookInfo[0]['wordcount'];
                }

                if(empty($this->Book['thumb']) && !empty($bookInfo[0]['thumb']) && strpos($bookInfo[0]['thumb'],'noimg.gif') === false){
                    $thumb = save_remote_thumb($config['baseUrl'] . substr($bookInfo[0]['thumb'], 1));

                    if(env('APP_DEBUG') == false){
                        //上传到七牛
                        $qiniuThumb = uploadToQiniu(public_path().$thumb);
                        $updateData['thumb'] = $qiniuThumb;
                        \File::delete(public_path().$thumb);
                    }else{
                        $updateData['thumb'] = $thumb;
                    }
                }
            }

            //获取章节列表
            $rules = $config['detail_list'];

            $html = request_spider($this->Book['fromurl']);
            $booksDetailLists = QueryList::Query($html , $rules['rules'] , $rules['range'] ,'UTF-8','GBK',true)->data;

            if(count($booksDetailLists)){

                $baseUrl = str_replace('Default.shtml' , '' , $this->Book['fromurl']);

                foreach($booksDetailLists as $k => &$v){
                    $v = array_map('trim',$v);
                    if(empty($v['fromurl'])){
                        unset($booksDetailLists[$k]);
                    }else{
                        if(substr($v['fromurl'],0,4) !== 'http') $v['fromurl'] = $baseUrl . $v['fromurl'];
                    }
                }

                $lastArticle = $this->getLastArticle($this->Book['id']);
                $firstChapterid = $lastArticle ? $lastArticle['chapterid'] + 1 : 1;

                //logwrite('--- LAST DATA : ' . var_export($lastArticle , true));
                if($lastArticle){
                    //chapterid = $offset + 1;
                    $links = $this->Count ? array_slice($booksDetailLists, $firstChapterid - 1, $this->Count) : array_slice($booksDetailLists, $firstChapterid - 1);
                }else{
                    $links = $this->Count ? array_slice($booksDetailLists, 0, $this->Count) : array_slice($booksDetailLists, $firstChapterid - 1);
                }

                $zhangjie = end($links);
                if(is_array($zhangjie) && isset($zhangjie['title'])){
                    $updateData['zhangjie'] = $zhangjie['title'];
                }
                $updateData['updated_at'] = date('Y-m-d H:i:s');
                DB::table('books')->where('id',$this->Book['id'])->update($updateData);

                foreach($links as $v){
                    dispatch(
                        new Wx999Content( array_merge($v,['chapterid' => $firstChapterid++,'pid' => $this->Book['id']]) )
                    );
                }
                unset($html,$booksDetailLists,$links);
            }
        }catch(\Exception $exception){
            logwrite(' --- 采集失败 --- ' . $exception->getMessage() . ' --- FILE '.$exception->getFile().' --- LINE ' . $exception->getLine());
        }
        return true;
    }

    /**
     * 处理一个失败的任务
     *
     * @return void
     */
//    public function failed()
//    {
//
//    }

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
     * 详情页链接
     * @param $baseUrl
     * @param $fromUrl
     * @return string
     */
    protected function getIndexUrl($baseUrl, $fromUrl)
    {
        $idTmp = str_replace('/Default.shtml' , '' , $fromUrl);
        $id = substr($idTmp,strrpos($idTmp , '/') + 1);
        $indexUrl = $baseUrl . 'Book/'. $id .'.aspx';//介绍页链接
        return $indexUrl;
    }
}
