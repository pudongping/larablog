<?php

use Illuminate\Database\Seeder;
use App\Models\Portal\Article\Article;
use App\Models\Portal\Article\Tag;

class ArticleTagPivotTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 所有文章 id 数组
        $articleIds = Article::all()->pluck('id')->toArray();
        // 所有标签 id 数组
        $tagIds = Tag::all()->pluck('id')->toArray();

        $data = [];
        for ($i = 0; $i < 100; $i++) {
            // 从文章 id 数组中随机取出一个值
            $item['article_id'] = \Arr::random($articleIds);
            $item['tag_id'] = \Arr::random($tagIds);
            $data[] = $item;
        }

        \DB::table('article_tag_pivot')->insert($data);

    }
}
