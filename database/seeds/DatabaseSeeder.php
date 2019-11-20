<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // https://learnku.com/docs/laravel/6.x/eloquent/5176#mass-assignment
        // 关闭模型插入或更新操作引发的 「mass assignment」异常 （临时取消掉批量赋值保护机制）
        Model::unguard();

        $this->call(UsersTableSeeder::class);
        $this->call(ArticlesTableSeeder::class);
        $this->call(RepliesTableSeeder::class);
        $this->call(LinksTableSeeder::class);
        $this->call(FansTableSeeder::class);

        // 重新开启「mass assignment」异常抛出功能 （开启批量赋值保护机制）
        Model::reguard();
    }
}
