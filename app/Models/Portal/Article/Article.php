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
     * 站点地图缓存名称
     *
     * @var string
     */
    public $cacheKeyForSiteMap = 'site-map';

    /**
     * 缓存过期时间为 24 小时
     *
     * @var float|int 秒数
     */
    public $cacheExpireInSeconds = 1440 * 60;

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
        return $query->with('category', 'tags', 'user');
    }

    /**
     * 「最后回复」的本地作用域
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecentReplied($query)
    {
        return $query->orderBy('articles.updated_at', 'desc');
    }

    /**
     * 「最新发布」的本地作用域
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('articles.created_at', 'desc');
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
    public function updateReplyCount()
    {
        $this->reply_count = $this->replies->count();
        $this->save();
    }

    /**
     * 获取文章和标签的多对多关系
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'article_tag_pivot', 'article_id', 'tag_id')->withTimestamps();
    }

    /**
     * 更新标签 （包含新增和删除）
     *
     * @param array $tagIds  需要更新的标签数组
     */
    public function updateTags(array $tagIds)
    {
        $this->tags()->sync($tagIds);
    }


}
