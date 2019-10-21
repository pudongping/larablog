<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
    }
}
