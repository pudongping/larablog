<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;
use App\Models\Auth\User;

class AuthenticationController extends Controller
{

    /**
     * 将用户重定向到授权提供方的授权页面，比如：GitHub
     *
     * @param $social  string  授权提供方，文档中支持：facebook, twitter,  linkedin, google, github, gitlab, bitbucket
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getSocialRedirect($social)
    {
        if (! in_array($social, User::$allowedProviders)) {
            return redirect()->route('login')->with('warning', '当前不支持使用 「 ' . $social . ' 」登录！');
        }

        try {
            return Socialite::with($social)->redirect();
        } catch (\InvalidArgumentException $e) {
            return redirect()->route('login');
        }
    }

    /**
     * 从授权提供方获取用户信息，比如：Github
     *
     * @param $social  string  授权提供方，文档中支持：facebook, twitter,  linkedin, google, github, gitlab, bitbucket
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getSocialCallback($social)
    {

        if (! in_array($social, User::$allowedProviders)) {
            return redirect()->route('login')->with('warning', '当前不支持使用 「 ' . $social . ' 」登录！');
        }

        try {
            // 从第三方 OAuth 回调中获取用户信息
            $socialUser = Socialite::with($social)->user();
        } catch (\Exception $e) {
            session()->flash('warning', '授权登录失败！请重试几次，或直接使用账号登录！');
            return redirect()->route('login');
        }

        // 判断当前授权用户是否在 users 表中
        $user = User::where('provider_id', $socialUser->id)->where('provider', $social)->first();

        if (is_null($user)) {
            // 如果当前授权用户不在 users 表中，则将当前用户信息保存到 users 表中
            $newUser = new User();
            $newUser->name              = $socialUser->getName() ?? $socialUser->getNickname() ?? '';
            $newUser->email             = $socialUser->getEmail() ?? '';
            $newUser->avatar            = $socialUser->getAvatar();
            $newUser->provider          = trim($social);
            $newUser->provider_id       = $socialUser->getId();
            $newUser->email_verified_at = date('Y-m-d H:i:s');
            $newUser->save();
            $user = $newUser;
        }

        // 手动登录该用户
        \Auth::login($user);

        session()->flash('success', '「 ' . $user->name . ' 」，欢迎回来！');
        $fallback = route('users.show', \Auth::user());
        // 将页面重定向到上一次请求尝试访问的页面上，并接收一个默认跳转地址参数，当上一次请求记录为空时，跳转到默认地址上
        return redirect()->intended($fallback);
    }

}
