<?php

namespace App\Observers\Portal\Article;

use App\Models\Portal\Article\Article;
use App\Jobs\TranslateSlug;

class ArticleObserver
{

    /**
     * creating, created, updating, updated, saving,
     * saved,  deleting, deleted, restoring, restored
     * 当一个新模型被初次保存将会触发 creating 以及 created 事件
     * 如果一个模型已经存在于数据库且调用了 save 方法，将会触发 updating 和 updated 事件
     * 在以上两种情况下都会触发 saving 和 saved 事件
     */

    /**
     * 此时数据还没有在数据库中创建
     *
     * @param Article $article
     */
    public function saving(Article $article)
    {
        // 使用 「HTMLPurifier for Laravel」 对文章内容进行 XSS 过滤
        $article->body = clean($article->body, 'user_article_body');

        // 截取文章内容以生成摘录
        $article->excerpt = make_excerpt($article->body);

    }

    /**
     * 此时已经在数据库中已经创建好了数据
     *
     * @param Article $article
     */
    public function saved(Article $article)
    {
        // 推送任务到队列，翻译文章标题
        dispatch(new TranslateSlug($article));
    }

    /**
     * 模型初次创建时会触发 created 事件
     *
     * @param  \App\Article  $article
     * @return void
     */
    public function created(Article $article)
    {
        // 重新计算当前用户发表了多少文章，并将文章总数更新到用户表 「article_count」 字段中
        $article->user->upadteArticleCount();
    }

    /**
     * Handle the article "updated" event.
     *
     * @param  \App\Article  $article
     * @return void
     */
    public function updated(Article $article)
    {
        //
    }

    /**
     * Handle the article "deleted" event.
     *
     * @param  \App\Article  $article
     * @return void
     */
    public function deleted(Article $article)
    {
        // 当文章删除后，该文章所对应的评论也全部被删除
        // 避免再次触发 Eloquent 事件，以免造成联动逻辑冲突。所以这里我们使用了 DB 类进行操作
        // deleted 方法只对 「Eloquent 模型」 有效
        \DB::table('replies')->where('article_id', $article->id)->delete();

        // 重新计算当前用户发表了多少文章，并将文章总数更新到用户表 「article_count」 字段中
        $article->user->upadteArticleCount();

    }

    /**
     * Handle the article "restored" event.
     *
     * @param  \App\Article  $article
     * @return void
     */
    public function restored(Article $article)
    {
        //
    }

    /**
     * Handle the article "force deleted" event.
     *
     * @param  \App\Article  $article
     * @return void
     */
    public function forceDeleted(Article $article)
    {
        //
    }
}
