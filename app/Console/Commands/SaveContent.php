<?php
/*
 * 推送链接到搜索引擎
 * */
namespace App\Console\Commands;

use Illuminate\Console\Command;
//use Illuminate\Foundation\Inspiring;

use App\Repositories\BookChapterRepository;
use DB;

class SaveContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'savecontent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'move database content to filesystem';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(BookChapterRepository $bookChapterRepository)
    {
        //$users = $bookChapterRepository->lists();
        $count = $bookChapterRepository->count();
        $this->output->progressStart($count);
        $pageSize = 100;
        $page = ceil($count / $pageSize);



        for ($i = 1; $i <= $page; $i ++) {
            $offset = ($page - 1) * $pageSize;
            $datas = DB::table('books_detail')->skip($offset)->take($pageSize)->get();
            $ids = $infos = [];
            foreach ($datas as $data) {
                $ids[] = $data['id'];
                $infos[$data['id']] = [
                    'pid' => $data['pid'],
                    'chapterid' => $data['chapterid']
                ];
            }
            $contents = DB::table('books_content')->whereIn('id', $ids)->get();
            foreach ($contents as $content) {
                if (empty($content)) {
                    continue;
                }
                $bookChapterRepository->setContent($infos[$content['id']]['pid'], $infos[$content['id']]['chapterid'], $content['content']);
            }
            $this->output->progressAdvance();
        }

        $this->output->progressFinish();
        return true;
    }
}
