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
            ],
            [
                'name'        => 'Python',
                'description' => '人生苦短，我用 Python',
            ],
            [
                'name'        => 'Linux',
                'description' => '最适合程序员的操作系统',
            ],
            [
                'name'        => 'Git',
                'description' => '世界上最好用的分布式版本控制系统',
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
