<?php

namespace App\Models\Admin\Setting;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = ['title', 'link'];

    /**
     * 缓存名称
     *
     * @var string
     */
    public $cacheKey = 'links';

    /**
     * 缓存过期时间为 24 小时
     *
     * @var float|int 秒数
     */
    protected $cacheExpireInSeconds = 1440 * 60;

    /**
     * 获取 links 的缓存过期时间
     *
     * @return float|int
     */
    public function getCacheExpireInSeconds()
    {
        return $this->cacheExpireInSeconds;
    }


}
