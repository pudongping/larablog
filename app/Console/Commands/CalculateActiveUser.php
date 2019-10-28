<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Auth\User;

class CalculateActiveUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larablog:calculate-active-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '计算活跃用户';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('正在计算当前活跃用户……');
        // 计算当前活跃用户并将其设置缓存
        app(User::class)->calculateAndCacheActiveUsers();
        $this->info('当前活跃用户计算完毕！');
    }
}
