<?php
/**
 * 记录用户最后活跃时间
 *
 * Created by PhpStorm.
 * User: Alex
 * Date: 2019/10/28
 * Time: 22:33
 */

namespace App\Http\Middleware;

use Closure;

class RecordLastActivedTime
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
        // 如果是登录用户的话
        if (\Auth::check()) {
            // 记录最后登录的时间
            \Auth::user()->recordLastActivedAt();
        }

        return $next($request);
    }
}
