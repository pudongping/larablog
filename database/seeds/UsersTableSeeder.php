<?php

use Illuminate\Database\Seeder;
use App\Models\Auth\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 获取 Faker 实例
        $faker = app(Faker\Generator::class);

        $ids = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15];

        // 头像假数据
        $avatars = [];
        foreach ($ids as $id) {
            $avatars[] = "/uploads/portal/img/auth/users/{$id}.jpg";
        }

        // 生成数据集合
        // 根据指定的 User 生成模型工厂构造器，对应加载 UserFactory.php 中的工厂设置
        $users = factory(User::class)
            ->times(10)
            ->make()
            ->each(function (
                $user,
                $index
            ) use (
                $faker,
                $avatars
            ) {
                // 从头像数组中随机取出一个并赋值
                $user->avatar = $faker->randomElement($avatars);
            });

        // 让隐藏字段可见，并将数据集合转换为数组，确保入库时数据库不会报错。
        $userArray = $users->makeVisible(['password', 'remember_token'])->toArray();

        // 插入到数据库中
        User::insert($userArray);

        // 单独处理第一个用户的数据
        $user = User::find(1);

        // 初始化用户角色，将 1 号用户指派为「站长」
        $user->assignRole('Founder');

        $user->name = 'alex';
        $user->email = '1414818093@qq.com';
        $user->email_verified_at = date('Y-m-d H:i:s');
        $user->avatar = '/uploads/portal/img/auth/users/21.jpg';
        $user->password = bcrypt('123456');
        $user->save();

        $user = User::find(2);

        // 将 2 号用户指派为「管理员」
        $user->assignRole('Maintainer');

        $user->name = 'dongping';
        $user->email = '276558492@qq.com';
        $user->save();

    }
}
