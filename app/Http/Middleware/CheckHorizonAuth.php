<?php

namespace App\Http\Middleware;

use Closure;

class CheckHorizonAuth
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

        \Horizon::auth(function($request){
            // 当前用户是否为 「站长」
            return \Auth::user()->hasRole('Founder');
        });

        return $next($request);
    }
}
