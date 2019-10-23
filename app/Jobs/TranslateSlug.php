<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
// 该接口表明 Laravel 应该将该任务添加到后台的任务队列中，而不是同步执行。
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
// Eloquent 模型会被优雅的序列化和反序列化
use Illuminate\Queue\SerializesModels;
use App\Models\Portal\Article\Article;
use App\Handlers\SlugTranslateHandler;

class TranslateSlug implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $article;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Article $article)
    {
        // 队列任务构造器中接收了 Eloquent 模型，将会只序列化模型的 ID
        // 这样子在任务执行时，队列系统会从数据库中自动的根据 ID 检索出模型实例。
        // 这样可以避免序列化完整的模型可能在队列中出现的问题。
        $this->article = $article;
    }

    /**
     * Execute the job.
     * handle 方法会在队列任务执行时被调用
     *
     * @return void
     */
    public function handle()
    {
        // 请求百度 API 接口进行翻译
        // 使用 app() 方法生成 SlugTranslateHandler 实例
        // https://xueyuanjun.com/post/19920.html
        $slug = app(SlugTranslateHandler::class)->translate($this->article->title);

        // 当文章含有「edit」或者「编辑」时，添加文章时，会直接到文章编辑页，因此将此时的 $slug 更改为 「edit-slug」
        ('edit' === trim($slug)) && ($slug = 'edit-slug');

        /**
         * 任务中要避免使用 Eloquent 模型接口调用，如：create(), update(), save() 等操作。
         * 否则会陷入调用死循环 —— 模型监控器分发任务，任务触发模型监控器，模型监控器再次分发任务，任务再次触发模型监控器.... 死循环。
         * 在这种情况下，使用 DB 类直接对数据库进行操作即可。
         */
        // 为了避免模型监控器死循环调用，我们使用 DB 类直接对数据库进行操作
        \DB::table('articles')->where('id', $this->article->id)->update(['slug' => $slug]);
    }

}
