<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;

class SeedRolesAndPermissionsData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 需清除缓存，否则会报错
        app(Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        // 先创建权限
        // 管理站点信息的权限
        Permission::create(['name' => 'manage_settings', 'cn_name' => '站点设置']);
        // 管理内容的权限
        Permission::create(['name' => 'manage_contents', 'cn_name' => '管理内容']);
        // 管理用户的权限
        $p1 = Permission::create(['name' => 'manage_users', 'cn_name' => '管理用户']);
        $p2 = Permission::create(['name' => 'add_user', 'cn_name' => '添加用户', 'pid' => $p1->id]);
        $p3 = Permission::create(['name' => 'edit_user', 'cn_name' => '修改用户', 'pid' => $p1->id]);
        $p4 = Permission::create(['name' => 'del_user', 'cn_name' => '删除用户', 'pid' => $p1->id]);
        $p5 = Permission::create(['name' => 'read_user', 'cn_name' => '查看用户', 'pid' => $p1->id]);

        // 创建角色
        // 创建站长角色，并赋予所有权限
        $founder = Role::create(['name' => 'Founder', 'cn_name' => '站长']);
        // 为站长赋予所有权限
        $founder->givePermissionTo(Permission::all());

        // 创建管理员角色，并赋予权限
        $maintainer = Role::create(['name' => 'Maintainer', 'cn_name' => '管理员']);
        $maintainer->givePermissionTo('manage_contents');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 需清除缓存，否则会报错
        app(Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        // 清空所有数据表数据
        $tableNames = config('permission.table_names');

        Model::unguard();
        DB::table($tableNames['role_has_permissions'])->delete();
        DB::table($tableNames['model_has_roles'])->delete();
        DB::table($tableNames['model_has_permissions'])->delete();
        DB::table($tableNames['roles'])->delete();
        DB::table($tableNames['permissions'])->delete();
        Model::reguard();
    }
}
