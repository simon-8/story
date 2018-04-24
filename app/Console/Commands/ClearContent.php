<?php
/*
 * 删除无内容章节
 * */
namespace App\Console\Commands;

use Illuminate\Console\Command;
//use Illuminate\Foundation\Inspiring;

use App\Repositories\BookChapterRepository;
use DB;

class ClearContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear-chapter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'clear empty chapter';


    /**
     * @param BookChapterRepository $bookChapterRepository
     * @return bool
     */
    public function handle(BookChapterRepository $bookChapterRepository)
    {
        $count = $bookChapterRepository->count();

        $pageSize = 500;
        $page = ceil($count / $pageSize);

        $this->output->progressStart($page);

        for ($i = 1; $i <= $page; $i ++) {
            $offset = ($i - 1) * $pageSize;
            $datas = DB::table('books_detail')->skip($offset)->take($pageSize)->get();
            $ids = $infos = [];
            foreach ($datas as $data) {
                $content = $bookChapterRepository->getContent($data['pid'], $data['id']);
                if (empty($content)) {
                    $ids[] = $data['id'];
                }
            }
            // 删除无内容章节
            if (count($ids)) {
                DB::table('books_detail')->whereIn('id', $ids)->delete();
            }
            $this->output->progressAdvance();
        }

        $this->output->progressFinish();
        return true;
    }
}
