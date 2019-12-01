<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Support\Response;

class ViewGlobalVariableServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        // 向视图文件抛出通用变量

        // 因为生命周期的原因，需要先判断菜单表是否存在，存在才能够从菜单中取值，否则当 menus 表不存在时，执行 artisan 命令会报错
        if (\Schema::hasTable('menus')) {
            // 向管理后台所有视图传递通用变量
            $adminInitParams = app(Response::class)->getAdminMeta();
            view()->composer('admin.layouts.*', function ($view) use ($adminInitParams) {
                $view->with($adminInitParams);
            });
        }

        // 向门户指定视图传递通用变量
        if (\Schema::hasTable('categories') &&
            \Schema::hasTable('users') &&
            \Schema::hasTable('links') &&
            \Schema::hasTable('tags')) {
            $portalInitParams = app(Response::class)->getPortalMeta();
            view()->composer('portal.*', function ($vp) use ($portalInitParams) {
                $vp->with($portalInitParams);
            });
            view()->composer('auth.*', function ($va) use ($portalInitParams) {
                $va->with($portalInitParams);
            });
        }

    }
}
