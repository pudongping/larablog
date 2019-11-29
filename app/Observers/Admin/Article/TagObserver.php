<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 2019/11/30
 * Time: 1:12
 */

namespace App\Observers\Admin\Article;

use App\Models\Portal\Article\Tag;

class TagObserver
{
    public function saved(Tag $tag)
    {
        // 在保存标签时清空 tags 相关的缓存
        \Cache::forget($tag->cacheKey);
    }

    public function deleted(Tag $tag)
    {
        // 在标签删除的时候清空 tags 相关的缓存
        \Cache::forget($tag->cacheKey);
    }
}
