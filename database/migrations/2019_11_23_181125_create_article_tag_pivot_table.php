<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleTagPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_tag_pivot', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('article_id')->unsigned()->index()->comment('文章 id');
            $table->integer('tag_id')->unsigned()->index()->comment('标签 id');
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
        Schema::dropIfExists('article_tag_pivot');
    }
}
