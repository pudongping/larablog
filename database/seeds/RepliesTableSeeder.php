<?php

use Illuminate\Database\Seeder;
use App\Models\Auth\User;
use App\Models\Portal\Article\Article;
use App\Models\Portal\Article\Reply;

class RepliesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 所有用户 ID 数组，如：[1,2,3,4]
        $userIds = User::all()->pluck('id')->toArray();

        // 所有文章 ID 数组，如：[1,2,3,4]
        $articleIds = Article::all()->pluck('id')->toArray();

        // 获取 Faker 实例
        $faker = app(Faker\Generator::class);

        $replys = factory(Reply::class)
            ->times(1000)
            ->make()
            ->each(function (
                $reply,
                $index
            ) use (
                $userIds,
                $articleIds,
                $faker
            ) {
                // 从用户 ID 数组中随机取出一个并赋值
                $reply->user_id = $faker->randomElement($userIds);

                // 文章 ID，同上
                $reply->article_id = $faker->randomElement($articleIds);
            });

        // 将数据集合转换为数组，并插入到数据库中
        Reply::insert($replys->toArray());


    }
}
