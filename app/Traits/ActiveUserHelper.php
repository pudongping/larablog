<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 2019-10-28
 * Time: 9:53
 *
 * 活跃用户算法
 *
 * 系统 每一个小时 计算一次，统计 最近 7 天 所有用户发的 文章数 和 评论数，
 * 用户每发一个文章则得 4 分，每发一个回复得 1 分，计算出所有人的『得分』后再倒序，
 * 排名前八的用户将会显示在「活跃用户」列表里
 *
 * 假设用户 A 在 7 天内发了 10 篇文章，发了 5 条评论，则其得分为
 * 10 * 4 + 5 * 1 = 45
 *
 */

namespace App\Traits;

use App\Models\Portal\Article\Article;
use App\Models\Portal\Article\Reply;
use Carbon\Carbon;
use Cache;
use DB;

trait ActiveUserHelper
{

    // 用于临时存放用户数据
    protected $users = [];

    // 配置信息
    protected $articleWeight = 4; // 发布一篇文章的权重
    protected $replyWeight = 1;  // 发布一条回复的权重
    protected $passDays = 7; // 只取多少天内的数据
    protected $userNumber = 8; // 只取前八位用户

    // 缓存相关配置
    protected $cacheKey = 'active_users';
    // 缓存过期时间为 65 分钟
    protected $cacheExpireInSeconds = 65 * 60;

    /**
     * 计算活跃用户并设置缓存
     */
    public function calculateAndCacheActiveUsers()
    {
        // 取出活跃用户
        $activeUsers = $this->calculateActiveUsers();
        // 并加以缓存
        $this->cacheActiveUsers($activeUsers);
    }

    /**
     * 计算发布文章所得分数
     */
    private function calculateArticleScore()
    {
        // 前七天的当前时间，比如今天是 2019-10-28 10：29：55 那么此时返回 2019-10-21 10：29：55.497053 Asia/Shanghai (+08:00)
        $passDate = Carbon::now()->subDays($this->passDays);
        $articleUsers = Article::query()->select(DB::raw('user_id, count(id) as article_count'))
                                        ->where('created_at', '>=', $passDate)
                                        ->groupBy('user_id')
                                        ->get();

        // 计算发布文章的分数并赋值给用户
        foreach ($articleUsers as $value) {
            $this->users[$value->user_id]['score'] = $value->article_count * $this->articleWeight;
        }

    }

    /**
     * 计算回复文章所得分数
     */
    private function calculateReplyScore()
    {
        $passDate = Carbon::now()->subDays($this->passDays);
        $replyUsers = Reply::query()->select(DB::raw('user_id, count(id) as reply_count'))
                                      ->where('created_at', '>=', $passDate)
                                      ->groupBy('user_id')
                                      ->get();

        foreach ($replyUsers as $value) {
            // 计算回复得分
            $replyScore = $value->reply_count * $this->replyWeight;
            // 如果已经有分数，则累加
            if (isset($this->users[$value->user_id])) {
                $this->users[$value->user_id]['score'] += $replyScore;
            } else {
                // 当前如果没有分数则直接赋值
                $this->users[$value->user_id]['score'] = $replyScore;
            }
        }

    }

    /**
     * 获取活跃用户信息
     *
     * @return \Illuminate\Support\Collection
     */
    public function calculateActiveUsers()
    {
        // 发布文章所得分数
        $this->calculateArticleScore();
        // 回复文章所得分数
        $this->calculateReplyScore();

        // 从所得总分数组中按照分数的大小进行升序排列
        $users = \Arr::sort($this->users, function ($user) {
            return $user['score'];
        });

        // 将总分数组按照从大到小的数据排列，高分在前，低分在后，且保证用户id 「user_id」 不变
        $users = array_reverse($users, true);

        // 从数组中截取我们需要的长度，并且保证索引不被改变
        $users = array_slice($users, 0, $this->userNumber, true);

        // 新建一个空集合
        $activeUsers = collect();

        // 这里使用循环查询不使用 whereIn 主要是为了保证活跃用户的排名顺序不要发生改变
        // 数据量小的情况下循环查询，对数据库的压力也不会很大
        foreach ($users as $userId => $user) {
            // 找寻是否存在当前用户
            $user = self::find($userId);
            if ($user) {
                $activeUsers->push($user);
            }
        }

        return $activeUsers;

    }

    /**
     * 将活跃用户信息存入缓存中
     *
     * @param $activeUsers
     */
    public function cacheActiveUsers($activeUsers)
    {
        // 将数据存入缓存中
        Cache::put($this->cacheKey, $activeUsers, $this->cacheExpireInSeconds);
    }

    /**
     * 获取缓存中的活跃用户
     *
     * @return mixed
     */
    public function getActiveUsersFromCache()
    {
        // 尝试从缓存中取出 cackeKey 对应的数据。如果能取到，便直接返回数据。
        // 否则运行匿名函数中的代码来取出活跃用户数据，返回的同时做了缓存。
        return Cache::remember($this->cacheKey, $this->cacheExpireInSeconds, function () {
            return $this->calculateActiveUsers();
        });
    }

}
