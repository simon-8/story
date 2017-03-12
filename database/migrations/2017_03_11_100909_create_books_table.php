<?php
/*
 * 小说主表
 * */
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'books' , function(Blueprint $table){
            $table->increments('id');
            $table->unsignedMediumInteger('catid')->comment('分类ID');
            $table->string('title')->comment('标题');
            $table->string('introduce')->comment('简介');
            $table->string('zhangjie')->comment('章节');
            $table->string('author')->comment('作者');
            $table->unsignedBigInteger('wordcount')->comment('字数');
            $table->unsignedInteger('follow')->comment('关注人数');
            $table->unsignedBigInteger('hits')->comment('浏览次数');
            $table->unsignedTinyInteger('status')->comment('状态');
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
