<?php

namespace App\Observers\Portal\Article;

use App\Models\Portal\Article\Reply;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{

    /**
     * 当 Elequont 模型数据成功创建时，created 方法将会被调用
     *
     * @param Reply $reply
     */
    public function created(Reply $reply)
    {
        // 每有一次评论，文章中 「回复统计数」 则加一
        $reply->article->increment('reply_count', 1);
    }


}
