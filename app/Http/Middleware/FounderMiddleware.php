<?php

namespace App\Http\Middleware;

use App\Models\Auth\User;
use Closure;

class FounderMiddleware
{
    /**
     * 判断当前用户是否有 「站长」 权限
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 当前用户表中所有用户数量
        $users = User::all()->count();
        // 如果用户表中只有一个用户，那么则跳过权限判断
        if (1 <> $users) {
            // 判断当前登录用户是否有 「站长」 权限
            if (! \Auth::user()->hasRole('Founder')) abort(401);
        }
        return $next($request);
    }
}
