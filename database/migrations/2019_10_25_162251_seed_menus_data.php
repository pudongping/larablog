<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Admin\Menu;

class SeedMenusData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $menu1 = [
            'pid' => 0,
            'name' => '用户与权限',
        ];

        $m1 = Menu::insert($menu1);

        $menu2 = [
            [
                'pid' => 1,
                'name' => '权限与角色',
                'icon' => 'fa fa-key'
            ],
            [
                'pid' => 1,
                'name' => '用户',
                'icon' => 'fa fa-user-friends'
            ],
        ];

        $m2 = \DB::table('menus')->insert($menu2);

        $menu3 = [
            'pid' => 0,
            'name' => '设置',
        ];

        $m3 = \DB::table('menus')->insert($menu3);

        $menu4 = [
            'pid' => 4,
            'name' => '站点设置',
        ];

        $m4 = \DB::table('menus')->insert($menu4);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('menus')->truncate();
    }
}
