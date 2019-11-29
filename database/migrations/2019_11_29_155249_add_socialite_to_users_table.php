<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSocialiteToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('provider')->default('')->after('email')->comment('OAuth 服务提供方，如：github');
            $table->string('provider_id')->default('')->after('provider')->comment('当前授权唯一标识');
            $table->string('password')->nullable()->change();  // 第三方授权登录时，允许密码为空
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('provider');
            $table->dropColumn('provider_id');
            $table->string('password')->nullable(false)->change();
        });
    }
}
