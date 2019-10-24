<?php

namespace App\Observers\Portal\Article;

use App\Models\Portal\Article\Reply;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{

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

    }


}
