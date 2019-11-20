<?php

use Illuminate\Database\Seeder;
use App\Models\Auth\User;

class FansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $user = $users->first();
        $userId = $user->id;

        // 获取去除掉 id 为 1 的所有用户 id 数组
        $followers = $users->slice($userId);
        $followerIds = $followers->pluck('id')->toArray();

        // 关注除了 1 号用户以外的所有用户
        $user->follow($followerIds);

        // 除了 1 号用户以外的所有用户都来关注 1 号用户
        foreach ($followers as $follower) {
            $follower->follow([$userId]);
        }
    }
}
