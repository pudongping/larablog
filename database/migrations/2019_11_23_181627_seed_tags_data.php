<?php
/**
 * 标签表填充默认数据据
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SeedTagsData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tags = [
            [
                'name'        => 'PHP',
                'description' => 'PHP 是世界上最好的语言，没有之一',
                'btn_class'   => 'primary',
            ],
            [
                'name'        => 'Python',
                'description' => '人生苦短，我用 Python',
                'btn_class'   => 'info',
            ],
            [
                'name'        => 'Linux',
                'description' => '最适合程序员的操作系统',
                'btn_class'   => 'success',
            ],
            [
                'name'        => 'Git',
                'description' => '世界上最好用的分布式版本控制系统',
                'btn_class'   => 'danger',
            ],
        ];

        DB::table('tags')->insert($tags);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('tags')->truncate();
    }
}
