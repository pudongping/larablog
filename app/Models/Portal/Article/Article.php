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
        'title', 'body', 'category_id', 'excerpt', 'slug'
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


}
