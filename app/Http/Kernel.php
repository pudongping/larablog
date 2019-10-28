<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     * 全局中间件
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        // 修正代理服务器后的服务器参数
        \App\Http\Middleware\TrustProxies::class,
        // 检测是否应用是否进入『维护模式』
        // 详情见：https://learnku.com/docs/laravel/6.x/configuration/5125
        \App\Http\Middleware\CheckForMaintenanceMode::class,
        // 检测表单请求的数据是否过大
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        // 对提交的请求参数进行 PHP 函数 `trim()` 处理
        \App\Http\Middleware\TrimStrings::class,
        // 将提交请求参数中空子串转换为 null
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        // Web 中间件组，应用于 routes/web.php 路由文件，
        // 在 RouteServiceProvider 中设定
        'web' => [
            // Cookie 加密解密
            \App\Http\Middleware\EncryptCookies::class,
            // 将 Cookie 添加到响应中
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            // 开启会话
            \Illuminate\Session\Middleware\StartSession::class,

            // \Illuminate\Session\Middleware\AuthenticateSession::class,

            // 将系统的错误数据注入到视图变量 $errors 中
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            // 检验 CSRF ，防止跨站请求伪造的安全威胁
            // 详情见：https://learnku.com/docs/laravel/6.x/csrf/5137
            \App\Http\Middleware\VerifyCsrfToken::class,
            // 处理路由绑定
            // 详情见：https://learnku.com/docs/laravel/6.x/routing/5135
            \Illuminate\Routing\Middleware\SubstituteBindings::class,


            // 以下为自定义中间件
            // 初始化参数
            \App\Http\Middleware\InitParams::class,
            // 记录访问日志
            \App\Http\Middleware\LogInfo::class,
            // 强制用户邮箱认证
            \App\Http\Middleware\EnsureEmailIsVerified::class,
            // 记录用户最后活跃时间
            \App\Http\Middleware\RecordLastActivedTime::class,

        ],

        // API 中间件组，应用于 routes/api.php 路由文件，
        // 在 RouteServiceProvider 中设定
        'api' => [
            // 使用别名来调用中间件
            // 详情见：https://learnku.com/docs/laravel/6.x/middleware/5136
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     * 中间件别名设置，允许你使用别名调用中间件，例如上面的 api 中间件组调用
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        // 只有登录用户才能访问
        'auth' => \App\Http\Middleware\Authenticate::class,
        // HTTP Basic Auth 认证
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        // 处理路由绑定
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,

        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,

        // 用户授权功能
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        // 只有游客才能访问，在 register 和 login 请求中使用，只有未登录用户才能访问这些页面
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        // 签名认证，找回密码中会使用到
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        // 访问节流，类似于 『1 分钟只能请求 10 次』的需求，一般在 API 中使用
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        // Laravel 自带的强制用户邮箱认证的中间件
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    ];

    /**
     * The priority-sorted list of middleware.
     *
     * This forces non-global middleware to always be in the given order.
     *
     * 设定中间件优先级，此数组定义了除『全局中间件』以外的中间件执行顺序
     * 可以看到 StartSession 永远是最开始执行的，因为 StartSession 后，
     * 我们才能在程序中使用 Auth 等用户认证的功能。
     *
     *
     * @var array
     */
    protected $middlewarePriority = [
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\Authenticate::class,
        \Illuminate\Routing\Middleware\ThrottleRequests::class,
        \Illuminate\Session\Middleware\AuthenticateSession::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \Illuminate\Auth\Middleware\Authorize::class,
    ];
}
