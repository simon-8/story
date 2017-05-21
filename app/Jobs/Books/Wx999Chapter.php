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
    public function __construct($Book , $Count = 10)
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
            logwrite($this->Book);
            //更新文章详情 / 缩略图
            if(empty($this->Book['introduce']) || empty($this->Book['thumb']) || empty($this->Book['linkurl'])){
                $rules = [
                    'introduce' => [
                        '.sc+p' , 'text'
                    ],
                    'wordcount' => [
                        '#box4 p small' , 'text'
                    ],
                    'thumb' => [
                        '.wleft img' , 'src'
                    ],
                    'linkurl' => [
                        '#bt_1 a' , 'href'
                    ],
                ];
                $html = request_spider($this->Book['fromurl']);
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
                    }else{
                        $qiniuThumb = false;
                    }
                    if($qiniuThumb){
                        $updateData['thumb'] = $qiniuThumb;
                        \File::delete(public_path().$thumb);
                    }else{
                        $updateData['thumb'] = $thumb;
                    }
                }
            }

            $id = str_replace([$config['baseUrl'] . 'Book/' , '.aspx'] , '' , $this->Book['fromurl']);

            //获取章节列表
            $rules = $config['detail_list'];
            $pageurl = $config['baseUrl'] . str_replace(['{catid}' , '{id}'] , [$this->Book['catid'] , $id] , $rules['pageurl']);
            $html = request_spider($pageurl);
            $booksDetailLists = QueryList::Query($html , $rules['rules'] , $rules['range'] ,'UTF-8','GBK',true)->data;

            if(count($booksDetailLists)){

                $baseUrl = str_replace('Default.shtml' , '' , $pageurl);

                foreach($booksDetailLists as $k => &$v){
                    $v = array_map('trim',$v);
                    if(empty($v['fromurl'])){
                        unset($booksDetailLists[$k]);
                    }else{
                        if(substr($v['fromurl'],0,4) !== 'http'){
                            $v['fromurl'] = $baseUrl . $v['fromurl'];
                        }
                    }
                }

                $lastArticle = $this->getLastArticle($this->Book['id']);

                if($lastArticle){
                    $offset = 0;
                    foreach($booksDetailLists as $k => $v)
                    {
                        if($v['title'] == $lastArticle['title']){
                            $offset = $k;
                            break;
                        }
                    }
                    //从最后一个章节开始截取10章
                    //$links = array_slice($booksDetailLists, $offset+1 , $this->Count);
                    $links = array_slice($booksDetailLists, $offset+1);
                }else{
                    //$links = array_slice($booksDetailLists, 0 , $this->Count);
                    $links = array_slice($booksDetailLists, 0);
                }

                $zhangjie = end($links);
                if(is_array($zhangjie) && isset($zhangjie['title'])){
                    $updateData['zhangjie'] = $zhangjie['title'];
                }
                $updateData['updated_at'] = date('Y-m-d H:i:s');
                DB::table('books')->where('id',$this->Book['id'])->update($updateData);

                foreach($links as $v){
                    //sleep(1);
                    //推送到章节采集队列
                    dispatch(
                        new Wx999Content( array_merge($v,['pid' => $this->Book['id']]) )
                    );
                }
            }
        }catch(\Exception $exception){
            logwrite(' --- 采集失败 DATA ---' . $exception->getMessage());
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
        return DB::table('books_detail')->select('id','title','fromhash')->where('pid',$pid)->orderBy('id','desc')->first();
    }
}
