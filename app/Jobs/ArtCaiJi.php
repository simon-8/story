<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

class ArtCaiJi extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Log::debug('###############################################################################');
        \Log::debug('###############################################################################');
        \Log::debug('###############################################################################');
        \Log::debug('###############################################################################');
        \Log::debug(' 俺是队列 ' . date('Y-m-d H:i:s '));
        \Log::debug('###############################################################################');
        \Log::debug('###############################################################################');
        \Log::debug('###############################################################################');
        \Log::debug('###############################################################################');
    }
}
