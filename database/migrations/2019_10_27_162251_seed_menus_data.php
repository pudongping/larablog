<?php
/**
 * 菜单表填充默认数据
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            'pid'         => 0,
            'name'        => '用户与权限',
            'icon'        => 'fa fa-key',
            'description' => 'rbac',
        ];

        $id1 = \DB::table('menus')->insertGetId($menu1);

        $menu2 = [
            [
                'pid'  => $id1,
                'name' => '权限与角色',
                'icon' => 'fa fa-key'
            ],
            [
                'pid' => $id1,
                'name' => '用户',
                'icon' => 'fa fa-user-friends'
            ],
        ];

        $m2 = \DB::table('menus')->insert($menu2);

        $menu3 = [
            'pid' => 0,
            'name' => '系统设置',
            'icon' => 'fas fa-fw fa-cog',
            'description' => 'setting',
        ];

        $id3 = \DB::table('menus')->insertGetId($menu3);

        $menu4 = [
            'pid' => $id3,
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
