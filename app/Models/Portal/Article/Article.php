<?php

namespace App\Models\Portal\Article;

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
}
