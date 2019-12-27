<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Portal\Article\Article;

class SyncArticleViewCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larablog:sync-article-view-count';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '同步文章的访问量';

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
    public function handle(Article $article)
    {
        $this->info("正在开始同步文章访问量……");
        $article->syncArticleViewCount();
        $this->info("同步成功！");
    }
}
