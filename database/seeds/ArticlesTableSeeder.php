<?php

use Illuminate\Database\Seeder;
use App\Models\Auth\User;
use App\Models\Portal\Article\Category;
use App\Models\Portal\Article\Article;

class ArticlesTableSeeder extends Seeder
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
        // 所有分类 ID 数组，如：[1,2,3,4]
        $categoryIds = Category::all()->pluck('id')->toArray();

        // 获取 Faker 实例
        $faker = app(Faker\Generator::class);

        $articles = factory(Article::class)
            ->times(100)
            ->make()
            ->each(function (
                $article,
                $index
            ) use (
                $userIds,
                $categoryIds,
                $faker
            ) {
                // 从用户 ID 数组中随机取出一个并赋值
                $article->user_id = $faker->randomElement($userIds);

                // 文章分类，同上
                $article->category_id = $faker->randomElement($categoryIds);
            });

        // 将数据集合转换为数组，并插入到数据库中
        Article::insert($articles->toArray());
    }

}
