<?php
/*
 * 链接提交记录
 * */
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableLinksubmit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('linksubmit', function(Blueprint $table){
            $table->string('site')->default('baidu')->comment('百度|360|搜狗|谷歌');
            $table->unsignedBigInteger('bookid')->comment('书本ID');
            $table->unsignedInteger('detailid')->comment('Detail表ID');
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
        //
    }
}
