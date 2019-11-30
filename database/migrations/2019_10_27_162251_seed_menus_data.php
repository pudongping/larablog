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
        $menu1 = ['pid' => 0, 'name' => '用户与权限', 'icon' => 'fa fa-key', 'description' => 'rbac'];
        $id1   = \DB::table('menus')->insertGetId($menu1);

        $menu2 = [
            ['pid' => $id1, 'name' => '权限与角色', 'link' => 'roles.index'],
            ['pid' => $id1, 'name' => '用户', 'link' => 'users.index'],
        ];
        $m2    = \DB::table('menus')->insert($menu2);

        $menu3 = ['pid' => 0, 'name' => '系统设置', 'icon' => 'fas fa-fw fa-cog', 'description' => 'setting'];
        $id3   = \DB::table('menus')->insertGetId($menu3);

        $menu4 = [
            ['pid' => $id3, 'name' => '系统菜单', 'link' => 'menus.index'],
            ['pid' => $id3, 'name' => '资源推荐', 'link' => 'links.index'],
            ['pid' => $id3, 'name' => '站点设置', 'link' => 'sites.edit'],
        ];
        $m4    = \DB::table('menus')->insert($menu4);

        $menu5 = ['pid' => 0, 'name' => '内容管理', 'icon' => 'fas fa-fw fa-folder', 'description' => 'content'];
        $id5   = \DB::table('menus')->insertGetId($menu5);

        $menu6 = [
            ['pid' => $id5, 'name' => '分类', 'link' => 'categories.index'],
            ['pid' => $id5, 'name' => '标签', 'link' => 'tags.index'],
            ['pid' => $id5, 'name' => '文章', 'link' => 'articles.index'],
        ];
        $m6    = \DB::table('menus')->insert($menu6);

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
