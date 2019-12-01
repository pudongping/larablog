<?php

namespace App\Http\Middleware;

use Closure;

class CheckAdminMenusMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 如果当前请求的 url 没有设置路由别名，则直接跳过
        if (! \Route::currentRouteName()) {
            return $next($request);
        }

        // 当前请求的 url 的别名，比如：menus.index
        $currentRouteName = \Route::currentRouteName();

        // 查询当前请求的路由是否设置了权限
        $menuAuth = \DB::table('menus')->where('link', $currentRouteName)->value('auth');

        if ($menuAuth) {
            // 检查用户是否有相应权限
            $isAuth = \Auth::user()->hasPermissionTo($menuAuth);
            // 如果没有相应权限则提示 401
            if (! $isAuth) abort(401);
        }

        return $next($request);
    }
}
