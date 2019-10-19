<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // 所有的控制器动作需要登录后才能访问
        $this->middleware('auth');
        // 只对 verify 方法设置 signed 路由签名中间件进行认证
        $this->middleware('signed')->only('verify');
        // 限定 verify 和 resend 方法访问频率为 1 分钟内不能超过 6 次
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }
}
