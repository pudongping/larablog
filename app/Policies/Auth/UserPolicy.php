<?php

namespace App\Policies\Auth;

use App\Models\Auth\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * 用户授权策略
     * 1、我们并不需要检查 $currentUser 是不是 null。未登录用户，框架会自动为其 「所有权限」 返回 false
     * 2、调用时，默认情况下，我们 不需要 传递当前登录用户至该方法内，因为框架会自动加载当前登录用户
     *
     * @param User $currentUser  当前登录用户实例
     * @param User $user  要进行授权的用户实例
     * @return bool  当两个用户是相同用户时为 true
     */
    public function updatePolicy(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }

    /**
     * 用户自己不能关注自己
     *
     * @param User $currentUser
     * @param User $user
     * @return bool
     */
    public function followPolicy(User $currentUser, User $user)
    {
        return $currentUser->id !== $user->id;
    }

}
