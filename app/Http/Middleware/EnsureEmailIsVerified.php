<?php
/**
 * 验证用户是否经过邮箱认证
 *
 * Created by PhpStorm.
 * User: Alex
 * Date: 2019/10/18
 * Time: 18:37
 */

namespace App\Http\Middleware;

use Closure;

class EnsureEmailIsVerified
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
        /**
         * 1、如果用户已经登录
         * 2、并且还没有验证 Email
         * 3、并且访问的不是 Email 验证相关的 URL 或者退出的 URL
         */
        if (
            $request->user() &&
            ! $request->user()->hasVerifiedEmail() &&
            ! $request->is('email/*', 'logout')
        ) {
            // 根据客户端返回相应的内容
            return $request->expectsJson()
                    ? abort(403, '您的邮箱还没有验证，请先验证邮箱！')
                    : redirect()->route('verification.notice');
        }

        return $next($request);
    }
}
