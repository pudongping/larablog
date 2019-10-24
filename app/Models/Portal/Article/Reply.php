<?php

namespace App\Models\Portal\Article;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    /**
     * 允许批量修改的字段
     *
     * @var array
     */
    protected $fillable = ['content'];

    /**
     * 一条回复评论对应一篇文章
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id', 'id');
    }

    /**
     * 一条评论回复对应一个作者
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


}
