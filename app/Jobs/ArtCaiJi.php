<?php
/*
 * 抓取任务列表
 * */
namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

use QL\QueryList;
use DB;
use App\Jobs\ArticleDetail;
class ArtCaiJi extends Job implements SelfHandling, ShouldQueue
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
        //if($this->attempts() > 3){

        //}
        \Log::debug(' --- ');
        if( $this->Book['fromurl'] && $this->Book['id'] ){

            //更新文章详情 / 缩略图
            if(empty($this->Book['introduce']) || empty($this->Book['thumb'])){

                $rules = [
                    'introduce' => [
                        '.intro','text'
                    ],
                    'thumb' => [
                        '.lf img','src'
                    ],
                ];
                $html = QueryList::Query($this->Book['fromurl'] , $rules , '' ,'UTF-8','GBK',true);
                $bookInfo = $html->getData();

                $updateData = [];
                if(empty($this->Book['introduce']) && !empty($bookInfo[0]['introduce'])){
                    $updateData['introduce'] = $bookInfo[0]['introduce'];
                }

                if(empty($this->Book['thumb']) && !empty($bookInfo[0]['thumb']) && strpos($bookInfo[0]['thumb'],'nocover.jpg') === false){
                    $thumb = save_remote_thumb($bookInfo[0]['thumb']);

                    //上传到七牛
                    $qiniuThumb = uploadToQiniu(public_path().$thumb);
                    if($qiniuThumb){
                        $updateData['thumb'] = $qiniuThumb;
                        \File::delete(public_path().$thumb);
                    }else{
                        $updateData['thumb'] = $thumb;
                    }
                }

            }

            //获取章节列表
            $rules = config('book.rules.88dushu.detail_list');
            $book = $html->setQuery($rules);
            $booksDetailLists = $book->getData();

            if(count($booksDetailLists)){

                $baseUrl = $this->Book['fromurl'];

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
                        if($v['title'] == $lastArticle->title){
                            $offset = $k;
                            break;
                        }
                    }
                    //从最后一个章节开始截取10章
                    $links = array_slice($booksDetailLists, $offset+1 , $this->Count);
                }else{
                    $links = array_slice($booksDetailLists, 0 , $this->Count);
                }

                $zhangjie = end($links);
                if(is_array($zhangjie) && isset($zhangjie['title'])){
                    $updateData['zhangjie'] = $zhangjie['title'];
                }
                $updateData['updated_at'] = date('Y-m-d H:i:s');
                DB::table('books')->where('id',$this->Book['id'])->update($updateData);

                foreach($links as $v){
                    //推送到章节采集队列
                    dispatch(
                        new ArticleDetail( array_merge($v,['pid' => $this->Book['id']]) )
                    );
                }
            }
        }
        return true;
    }

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
