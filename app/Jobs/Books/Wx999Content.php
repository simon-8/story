<?php
/*
 * 采集具体章节
 * */
namespace App\Jobs\Books;

use App\Jobs\Job;
use App\Repositories\BookChapterRepository;
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
    public function handle(BookChapterRepository $bookChapterRepository)
    {
        $html = request_spider($this->Info['fromurl']);
        $match = array();
        preg_match_all('/<div id="tipinfo">(.*?)<div id="Adsgg2">/isU', $html, $match);
        $content = str_replace(array('<div id="Adsgg2">') , '' , $match[0][0]);
        $content = preg_replace('/<script.*?<\/script>/is', '', $content);
        $content = iconv('gb2312' ,'utf-8//IGNORE',strip_tags($content , '<br><br/><br />'));

        $data = [
            'pid'       => $this->Info['pid'],
            'chapterid' => $this->Info['chapterid'],
            'title'     => $this->Info['title'],
            'hits'      => 0,
            'status'    => 1,
            'fromurl'   => $this->Info['fromurl'],
            'fromhash'  => md5($this->Info['fromurl']),
            'created_at'=> date('Y-m-d H:i:s'),
            'updated_at'=> date('Y-m-d H:i:s'),
        ];
        $id = DB::table('books_detail')->insertGetId($data);

        $result = $bookChapterRepository->setContent($this->Info['pid'], $this->Info['chapterid'] , $content);

        \Log::debug("Queue Result: {$id}, $result");
        unset($html, $match, $content);

        return true;
    }
}
