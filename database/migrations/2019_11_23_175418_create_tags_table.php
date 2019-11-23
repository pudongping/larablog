<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 10)->index()->unique()->comment('标签名称');
            $table->text('description')->nullable()->comment('标签描述');
            $table->integer('article_count')->default(0)->comment('该标签下文章总数');
            $table->enum('btn_class', ['primary', 'info', 'success', 'danger', 'secondary', 'dark'])->comment('标签样式');
            $table->integer('order')->unsigned()->default(0)->comment('排序');
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
        Schema::dropIfExists('tags');
    }
}
