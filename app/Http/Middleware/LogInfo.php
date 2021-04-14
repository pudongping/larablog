<?php
/**
 * 请求日志
 *
 * Created by PhpStorm.
 * User: Alex
 * Date: 2019/10/16
 * Time: 9:18
 */

namespace App\Http\Middleware;

use Closure;
use Log;

class LogInfo
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
        // 记录请求数据
        Log::info('Request', $this->getRequestInfo($request));

        $response = $next($request);

        // 记录控制器中最终返回的数据
        // $log = ['data' => $response->getContent()];

        // 返回有异常时
        if (property_exists($response, 'exception')) {
            // 将异常写入日志记录
            $log['exception'] = $response->exception;
            // 记录返回数据
            Log::info('Response', $log);
        }

        return $response;
    }

    /**
     * 获取请求信息
     *
     * @param $request 请求实例
     * @return array
     */
    private function getRequestInfo($request)
    {
        return [
            // 当前请求 ip 地址
            'ip' => $request->getClientIp(),
            // 当前请求方法：GET/POST……
            'method' => $request->method(),
            // 当前请求的 url
            'url' => $request->url(),
            // 请求中所有参数
            'params' => $request->all(),
        ];
    }

}
