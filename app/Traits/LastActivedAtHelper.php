<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 2019/10/28
 * Time: 22:52
 *
 * 记录用户最后登录的时间
 *
 */

namespace App\Traits;

use Redis;
use Carbon\Carbon;

trait LastActivedAtHelper
{

    // 哈希表名前缀
    protected $hashPrefix = 'larablog_last_actived_at_';
    // 哈希字段前缀
    protected $fieldPrefix = 'user_';


    /**
     * redis 记录当前用户最后活跃时间
     */
    public function recordLastActivedAt()
    {
        // 获取今天的日期
        $date = Carbon::now()->toDateString();

        // Redis 哈希表的命名，以天为度量，如：larablog_last_actived_at_2019-10-28
        $hash = $this->getHashFromDateString($date);

        // 字段名称，如：user_1
        $field = $this->getHashField();

       /*
        * 存入的数据如下所示
        *
        * dd(Redis::hGetAll($hash));
        *
        *
        * array:4 [▼
        *  "user_1" => "2019-10-28 23:03:40"
        *  "user_2" => "2019-10-28 23:03:49"
        *  "user_3" => "2019-10-28 23:03:59"
        *  "user_4" => "2019-10-28 23:04:01"
        * ]
       */

        // 当前时间，如：2019-10-28 23:35:15
        $now = Carbon::now()->toDateTimeString();

        // 数据写入 Redis ，字段已存在会被更新
        Redis::hSet($hash, $field, $now);
    }


    /**
     * 将昨天存入的「用户最后活跃时间」从 Redis 中取出，并存入数据库中
     */
    public function syncUserActivedAt()
    {
        // 获取昨天的日期，格式如：2019-10-27
        $yesterdayDate = Carbon::yesterday()->toDateString();

        // Redis 哈希表的命名，如：larablog_last_actived_at_2019-10-27
        $hash = $this->getHashFromDateString($yesterdayDate);

        // 从 Redis 中获取所有哈希表里的数据
        $dates = Redis::hGetAll($hash);

        /*
         * 此时的数据如下所示
         *
         * dd(Redis::hGetAll($hash));
         *
         *
         * array:4 [▼
         *  "user_1" => "2019-10-28 23:03:40"
         *  "user_2" => "2019-10-28 23:03:49"
         *  "user_3" => "2019-10-28 23:03:59"
         *  "user_4" => "2019-10-28 23:04:01"
         * ]
        */

        // 遍历，并同步到数据库中
        foreach ($dates as $userId => $activedAt) {
            // 会将 `user_1` 转换为 1
            $userId = str_replace($this->fieldPrefix, '', $userId);

            // 只有当用户存在时才更新到数据库中
            if ($user = $this->find($userId)) {
                $user->last_actived_at = $activedAt;
                $user->save();
            }
        }

        // 以数据库为中心的存储，既已同步，即可删除
        Redis::del($hash);
    }

    /**
     * 设置「用户最后活跃时间」访问器
     * 优先读取当日哈希表里 Redis 里的数据，无数据则使用数据库中的值
     *
     * @param $value  数据库中的 「用户最后活跃时间」
     * @return Carbon  Carbon 实体
     * @throws \Exception
     */
    public function getLastActivedAtAttribute($value)
    {
        // 获取今天的日期
        $date = Carbon::now()->toDateString();

        // Redis 哈希表的命名，以天为度量，如：larablog_last_actived_at_2019-10-28
        $hash = $this->getHashFromDateString($date);

        // 字段名称，如：user_1
        $field = $this->getHashField();

        // 优先从 Redis 中取数据，如果 Redis 中没有数据，那么就使用数据库中的数据
        $datetime = Redis::hGet($hash, $field) ?: $value;

        // 如果存在的话，返回时间对应的 Carbon 实体
        if ($datetime) {
            return new Carbon($datetime);
        } else {
            // 否则使用用户注册时间
            return $this->created_at;
        }

    }

    /**
     * 获取哈希表的表名
     *
     * @param  string  $date  日期，eg：2019-10-28
     * @return string  哈希表名
     */
    private function getHashFromDateString($date)
    {
        // Redis 哈希表的命名，以天为度量，如：larablog_last_actived_at_2019-10-28
        $hash = $this->hashPrefix . $date;
        return $hash;
    }

    /**
     * 获取哈希表的字段名
     *
     * @return string
     */
    private function getHashField()
    {
        // 字段名称，如：user_1
        $field = $this->fieldPrefix . $this->id;
        return $field;
    }


}