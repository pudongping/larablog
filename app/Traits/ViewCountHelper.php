<?php
/**
 * 文章访问统计
 *
 * Created by PhpStorm.
 * User: Alex
 * Date: 2019-12-26
 * Time: 18:51
 */

namespace App\Traits;

use Illuminate\Support\Facades\Redis;

trait ViewCountHelper
{

    /**
     * 哈希表名 - 文章访问统计
     *
     * @var string
     */
    protected $atlViewHashPrefix = 'larablog_article_views';

    /**
     * 记录文章访问量
     */
    public function recordViewCount()
    {
        // 先查询 hash 表中是否已有当前文章访问量
        $oldHashViewCount = Redis::hget($this->atlViewHashPrefix, $this->id);
        if ($oldHashViewCount) {
            // 以最多的访问量为主
            $oldViewCount = ($oldHashViewCount > $this->view_count) ? intval($oldHashViewCount) : $this->view_count;
        } else {
            // redis 中没有的话，则直接使用 mysql 数据库中的访问量
            $oldViewCount = $this->view_count;
        }

        // 页面每访问一次，哈希表自增 1
        Redis::hSet($this->atlViewHashPrefix, $this->id, $oldViewCount + 1);
        // 取出当前文章在 redis 中记录的访问量
        $hsViewCount = Redis::hget($this->atlViewHashPrefix, $this->id);
        // 优先使用 redis 中记录的访问量， redis 中不存在就使用数据库中保存的访问量
        $this->view_count = intval($hsViewCount) ?? $this->view_count;
    }

    /**
     * 同步 redis 中记录的文章访问量到 mysql 数据库中
     *
     * @return bool
     */
    public function syncArticleViewCount()
    {
        // 取出所有在 redis 中记录的文章访问量
        $viewCountInRDS = Redis::hGetAll($this->atlViewHashPrefix);
        if (empty($viewCountInRDS)) return false;

        $ids = array_keys($viewCountInRDS);
        $viewCounts = array_values($viewCountInRDS);

        // 批量更新数据
        batchUpdate('articles', ['id' => $ids], ['view_count' => $viewCounts]);
        // 文章访问量已经同步到 mysql 数据库中，就删除 redis 中的记录，防止 redis 中内存占满
        Redis::del($this->atlViewHashPrefix);
    }

    /**
     * 获取文章统计哈希表 key
     *
     * @return string
     */
    public function getAtlViewHashPrefix()
    {
        return $this->atlViewHashPrefix;
    }


}
