<?php

namespace App\Models\Portal\Article;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

    protected $fillable = ['name', 'description', 'btn_class', 'order'];

    /**
     * 缓存名称
     *
     * @var string
     */
    public $cacheKey = 'tags';

    /**
     * 缓存过期时间为 24 小时
     *
     * @var float|int 秒数
     */
    protected $cacheExpireInSeconds = 1440 * 60;

    /**
     * 标签颜色样式枚举
     *
     * @var array
     */
    public static $allowedBtnClass = ['primary', 'info', 'success', 'danger', 'secondary', 'dark'];

    /**
     * 获取 links 的缓存过期时间
     *
     * @return float|int
     */
    public function getCacheExpireInSeconds()
    {
        return $this->cacheExpireInSeconds;
    }

    /**
     * 获取标签和文章的多对多关系
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_tag_pivot', 'tag_id', 'article_id')->withTimestamps();
    }

}
