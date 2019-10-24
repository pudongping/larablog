<?php

namespace App\Models\Portal\Article;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /**
     * 允许修改的字段
     *
     * @var array
     */
    protected $fillable = [
        'title', 'body', 'category_id', 'excerpt', 'slug', 'user_id'
    ];

    /**
     * 一篇文章对应一个分类
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * 一篇文章对应一位作者
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * 一篇文章对应多条回复
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class, 'article_id', 'id');
    }

    /**
     * 排序规则动态作用域
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $order
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithOrder($query, $order)
    {
        switch ($order) {
            case 'recent':
                $query->recent();
                break;

            default:
                $query->recentReplied();
                break;
        }

        // 预加载防止 N+1 问题
        return $query->with('category', 'user');
    }

    /**
     * 「最后回复」的本地作用域
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecentReplied($query)
    {
        return $query->orderBy('updated_at', 'desc');
    }

    /**
     * 「最新发布」的本地作用域
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * 返回 SEO 友好的 URL
     *
     * @param array $params  附加 url 的其它参数
     * @return string  文章详情路由
     */
    public function link($params = [])
    {
        return route('articles.show', array_merge([$this->id, $this->slug], $params));
    }

    /**
     * 计算文章回复总数
     */
    public function upadteReplyCount()
    {
        $this->reply_count = $this->replies->count();
        $this->save();
    }


}
