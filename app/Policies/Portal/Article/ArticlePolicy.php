<?php

namespace App\Policies\Portal\Article;

use App\Models\Auth\User;
use App\Models\Portal\Article\Article;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
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
     * 文章编辑策略
     *
     * @param User $user  当前用户实例
     * @param Article $article  当前文章实例
     * @return bool
     */
    public function updatePolicy(User $user, Article $article)
    {
        return $user->isAuthorOf($article);
    }

    /**
     * 删除文章策略
     *
     * @param User $user  当前用户实例
     * @param Article $article  当前文章实例
     * @return bool
     */
    public function destroyPolicy(User $user, Article $article)
    {
        return $user->isAuthorOf($article);
    }

}
