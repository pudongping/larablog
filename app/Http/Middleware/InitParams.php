<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 2019/10/16
 * Time: 1:05
 */

namespace App\Http\Middleware;

use Closure;
use App\Support\TempValue;
use Auth;
use DB;
use Config;

class InitParams
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
        // 当前已经登陆的用户
        TempValue::$currentUser = Auth::user();
        // 是否开启 debug
        TempValue::$debug = $debug = $request->input('debug', 0);
        // 当前 http 请求方式
        TempValue::$httpMethod = strtolower($request->getMethod());
        // 当前控制器名称
        TempValue::$controller = $this->getCurrentControllerName();
        // 当前方法名称
        TempValue::$action = $this->getCurrentMethodName();

        // 是否分页，默认不分页
        TempValue::$nopage = $request->input('nopage', 0);
        // 当前页码，默认为第一页
        TempValue::$page = (int)$request->input('page', 1);
        // 分页显示数量
        TempValue::$perPage = $request->input('per_page');
        /**
         * 排序规则
         * 支持 TempValue::$orderBy = id,desc|name,asc
         * 支持 $sortColumn = ['id','name'] , $sort = ['desc','asc']
         */
        TempValue::$orderBy = $request->input('order_by');

        if (config('app.debug') && 1 == $debug) {
            // 开启 sql log
            DB::enableQueryLog();
            $connections = array_keys(Config::get('database.connections', []));
            foreach ($connections as $connection){
                // 循环开启每一种数据库的 log
                DB::connection($connection)->enableQueryLog();
            }
        }

        return $next($request);
    }

    /**
     * 获取当前控制器与方法
     *
     * @return array
     */
    public static function getCurrentAction()
    {
        $action = \Route::current()->getActionName();
        if (!strstr($action, '@')) {
            // 防止直接返回视图
            return ['controller' => false, 'method' => false];
        }
        list($controller, $method) = explode('@', $action);
        return compact('controller', 'method');
    }

    /**
     * 获取当前控制器名
     *
     * @return mixed
     */
    public function getCurrentControllerName()
    {
        return self::getCurrentAction()['controller'];
    }

    /**
     * 获取当前方法名
     *
     * @return mixed
     */
    public function getCurrentMethodName()
    {
        return self::getCurrentAction()['method'];
    }


}
