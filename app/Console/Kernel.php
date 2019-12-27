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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        // 每隔五分钟监听一下队列
        $schedule->command('queue:listen')->everyFiveMinutes();
        // 一小时执行一次『生成活跃用户』的命令
        $schedule->command('larablog:calculate-active-user')->hourly();
        // 每日零时执行一次『将 Redis 中的用户最后登录时间存入数据库中』的命令
        $schedule->command('larablog:sync-user-actived-at')->dailyAt('00:00');
        // 每日零时执行一次 『将 Redis 中的文章访问量存入数据库中』 的命令
        $schedule->command('larablog:sync-article-view-count')->dailyAt('00:00');

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
