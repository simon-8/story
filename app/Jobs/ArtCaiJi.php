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
    protected $Book;
    public function __construct($Book)
    {
        $this->Book = $Book;
    }

    /**
     * Execute the job.
     *
     * @return mixed
     */
    public function handle()
    {
        if($this->attempts() > 3){

        }
        if( $this->Book['linkurl'] && $this->Book['id'] ){
            $rules = [
                'introduce' => [
                    '.intro','text'
                ],
            ];
            $html = QueryList::Query($this->Book['linkurl'] , $rules , '' ,'UTF-8','GBK',true);
            $bookInfo = $html->getData();
            $introduce = $bookInfo[0]['introduce'];

            DB::table('books')->where('id',$this->Book['id'])->update([
                'introduce' => $introduce,
            ]);
            //获取章节列表
            $rules = config('book.rules.88dushu.detail_list');
            $book = $html->setQuery($rules);
            $booksDetailLists = $book->getData();

            $lastArticle = $this->getLastArticle($this->Book['id']);

            $offset = 0;

            foreach($booksDetailLists as $k => $v)
            {
                $v = array_map('trim',$v);
                if(!empty($v['linkurl']) && $v['title'] == $lastArticle->title){
                    $offset = $k;
                    break;
                }
            }

            //从最后一个章节开始截取10章
            $links = array_slice($booksDetailLists, $offset+1 , 10);

            $baseUrl = $this->Book['linkurl'];
            $tmp = array_map(function($v) use ($baseUrl){
                $v = array_map('trim',$v);
                if(substr($v['linkurl'],0,4) !== 'http'){
                    $v['linkurl'] = $baseUrl . $v['linkurl'];
                }
                return $v;
            },$links);

            foreach($tmp as $v){
                //推送到章节采集队列
                dispatch(
                    new ArticleDetail( array_merge($v,['pid' => $this->Book['id']]) )
                );
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
