<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Portal\Article\Reply;
use App\Observers\Portal\Article\ReplyObserver;
use App\Models\Admin\Setting\Link;
use App\Observers\Admin\Setting\LinkObserver;
use App\Models\Portal\Article\Tag;
use App\Observers\Admin\Article\TagObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * 注册服务提供者
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // 非 production 开发环境才注册以下服务
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        // 调试模式才注册以下服务
        if (config('app.debug')) {
            $this->app->register(\VIACreative\SudoSu\ServiceProvider::class);
        }

    }

    /**
     * 引导应用程序服务
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 注册观察者
        \App\Models\Portal\Article\Article::observe(\App\Observers\Portal\Article\ArticleObserver::class);
        // 注册发布评论的观察者
        Reply::observe(ReplyObserver::class);
        // 注册资源链接的观察者
        Link::observe(LinkObserver::class);
        // 注册标签的观察者
        Tag::observe(TagObserver::class);

    }
}
