<?php
/*
 * 采集具体章节
 * */
namespace App\Jobs\Books;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

use DB;
use QL\QueryList;

class Wx999Content extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $Info;//[pid,title,fromurl]
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
        $rules = config('books.wx999.content.rules');
        $html = request_spider($this->Info['fromurl']);
        $html = QueryList::Query($html , $rules , '' ,'UTF-8','GBK',true)->getData();
        $result = array_shift($html);
//        try{
        $data = [
            'pid'    => $this->Info['pid'],
            'title'  => $this->Info['title'],
            'hits'   => 0,
            'status' => 1,
            'fromurl' => $this->Info['fromurl'],
            'fromhash'   => md5($this->Info['fromurl']),
            'created_at'=> date('Y-m-d H:i:s'),
            'updated_at'=> date('Y-m-d H:i:s'),
        ];
        //事务
        DB::transaction(function () use ($result,$data) {
            try{
                $id = DB::table('books_detail')->insertGetId($data);
            }catch (\Exception $exception){
                return true;
            }

            DB::table('books_content')->insert([
                'id' => $id,
                'content' => ($result['content'] ? $result['content'] : ''),
            ]);
        });

//        }catch(\Exception $exception){
//            //忽略因为重复索引导致的插入失败
//            if(strpos($exception->getMessage() , '1062 Duplicate entry') !== false){
//                return true;
//            }
//        }
        return true;
    }
}
