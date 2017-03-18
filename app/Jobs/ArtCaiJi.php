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
            $rules = [
                'title' => [
                    '.mulu li a' , 'text'
                ],
                'linkurl' => [
                    '.mulu li a' , 'href'
                ],
            ];
            $book = $html->setQuery($rules);
            $booksDetailLists = $book->getData();

            $count = 0;

            foreach($booksDetailLists as $v)
            {
                $v = array_map('trim',$v);
                if(!empty($v['linkurl'])){

                    $v['linkurl'] = strpos($v['linkurl'],'http') === false ? $this->Book['linkurl'] . $v['linkurl'] : $v['linkurl'];

                    $detail = DB::table('books_detail')->where('fromhash',md5($v['linkurl']))->where('pid',$this->Book['id'])->first();
                    if( $detail ){
                        \Log::debug('-------> 该章节已采集过，跳过此节 -------> ' . $this->Book['title'] . '  章节: ' . $v['title']);
                    }else{
                        if($count > 9){
                            break;
                        }
                        //推送到章节采集队列
                        dispatch(
                            new ArticleDetail( array_merge($v,['pid' => $this->Book['id']]) )
                        );
                        $count++;
                    }
                }
            }
        }
        return true;
    }
}
