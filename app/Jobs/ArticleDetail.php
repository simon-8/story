<?php
/*
 * 采集具体章节
 * */
namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

use DB;
use QL\QueryList;

class ArticleDetail extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $Info;
    public function __construct($Info)
    {
        $this->Info = $Info;
    }

    /**
     * Execute the job.
     *
     * @return mixed
     */
    public function handle()
    {
        $rules = [
            'content' => [
                '.yd_text2','html'
            ]
        ];
        $html = QueryList::Query($this->Info['linkurl'] , $rules , '' ,'UTF-8','GBK',true)->getData();
        $result = array_shift($html);

        $id = DB::table('books_detail')->insertGetId([
            'pid'    => $this->Info['pid'],
            'title'  => $this->Info['title'],
            'hits'   => 0,
            'status' => 1,
            'fromhash'   => md5($this->Info['linkurl']),
            'created_at'=> date('Y-m-d H:i:s'),
            'updated_at'=> date('Y-m-d H:i:s'),
        ]);
        if($id){
            DB::table('books_content')->insert([
                'id' => $id,
                'content' => ($result['content'] ? $result['content'] : ''),
            ]);
        }else{
            \Log::debug('-------> 采集失败 -------> ' . $this->Info['linkurl']);
        }

        //\Log::debug('-------> 成功采集 -------> ' . $this->Info['title']);
        return true;
    }
}
