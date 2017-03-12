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

        DB::table('books_detail')->insert([
            'pid'    => $this->Info['pid'],
            'title'  => $this->Info['title'],
            'content'=> $result['content'],
            'hits'   => 0,
            'status' => 1,
            'created_at'=> date('Y-m-d H:i:s'),
            'updated_at'=> date('Y-m-d H:i:s'),
        ]);
        \Log::debug('-------> 成功采集 -------> ' . $this->Info['title']);
        return true;
    }
}
