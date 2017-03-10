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

use App\Jobs\ArticleDetail;
class ArtCaiJi extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $ArtInfo;
    public function __construct($ArtInfo)
    {
        $this->ArtInfo = $ArtInfo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if( $this->ArtInfo['linkurl'] ){

        }
        \Log::debug('###############################################################################');
        \Log::debug('###############################################################################');
        \Log::debug('###############################################################################');
        \Log::debug('###############################################################################');
        \Log::debug(' 调起真正的采集队列 ' . date('Y-m-d H:i:s '));
        \Log::debug('###############################################################################');
        \Log::debug('###############################################################################');
        \Log::debug('###############################################################################');
        \Log::debug('###############################################################################');
        //dispatch(new ArticleDetail());
    }
}
