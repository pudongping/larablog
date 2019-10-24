<?php

namespace App\Policies\Portal\Article;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Auth\User;
use App\Models\Portal\Article\Reply;

class ReplyPolicy
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
     * 删除评论策略
     *
     * @param User $user  当前用户实例
     * @param Article $article  当前回复实例
     * @return bool
     */
    public function destroyPolicy(User $user, Reply $reply)
    {
        // 文章作者和发布评论的本人才可以删除评论
        return $user->isAuthorOf($reply) || $user->isAuthorOf($reply->article());
    }

}
