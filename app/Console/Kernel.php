<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //\App\Console\Commands\Inspire::class,
        \App\Console\Commands\PushLink::class,
        \App\Console\Commands\SaveContent::class,
        \App\Console\Commands\ClearContent::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //$schedule->command('inspire')->hourly();

        // 链接推送
        $filepath = storage_path('logs'.DIRECTORY_SEPARATOR.'push-link-' . date('Ymd') . '.txt');
        $schedule->command('pushlink 1500')->hourly()->withoutOverlapping()->appendOutputTo($filepath)->when(function() {
            $searchEngine = \DB::table('linksubmit')->where('site', 'baidu')->first();
            $needSubmit = \DB::table('books_detail')->select('id','pid')->where('status',1)->where('id','>',$searchEngine['detailid'])->first();
            return $needSubmit ? true : false;
        });
    }
}
