<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('pid')->default(0)->comment('父级id，默认为0，则顶级菜单');
            $table->string('name', 100)->default('')->comment('菜单名称');
            $table->string('link')->default('')->comment('跳转连接');
            $table->string('auth')->default('')->comment('权限影响');
            $table->string('icon', 100)->default('fas fa-fw fa-cog')->comment('图标');
            $table->smallInteger('sort')->default(0)->comment('排序');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
