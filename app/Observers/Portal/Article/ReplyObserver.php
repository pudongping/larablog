<?php

namespace App\Observers\Portal\Article;

use App\Models\Portal\Article\Reply;
use App\Notifications\ArticleReplied;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{

    /**
     * 当数据创建保存时，对 content 字段进行净化处理
     *
     * @param Reply $reply
     */
    public function creating(Reply $reply)
    {
        $reply->content = clean($reply->content, 'user_article_body');
    }

    /**
     * 当 Elequont 模型数据成功创建时，created 方法将会被调用
     *
     * @param Reply $reply
     */
    public function created(Reply $reply)
    {
        // 每有一次评论，文章中 「回复统计数」 则加一，功能可以实现，但是不科学
        // $reply->article->increment('reply_count', 1);

        // 查询当前评论所属文章包含有多少评论，然后赋值给 「reply_count」 字段
        $reply->article->upadteReplyCount();

        // 通知文章作者有新的评论
        // 默认的 User 模型中使用了 trait —— Notifiable，它包含着一个可以用来发通知的方法 notify()
        // 当自己发表的文章自己回复时，就不要给与通知了
        if ($reply->article->user_id != \Auth::id()) {
            $reply->article->user->notify(new ArticleReplied($reply));
        }
    }

    /**
     * 模型删除时，调用 deleted 方法
     *
     * @param Reply $reply
     */
    public function deleted(Reply $reply)
    {
        // 当评论有删除时，更新文章评论数
        $reply->article->upadteReplyCount();
    }


}
