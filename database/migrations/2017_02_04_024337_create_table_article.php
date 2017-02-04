<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableArticle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'articles' ,function( Blueprint $table ){
            $table->increments('id');
            $table->unsignedInteger('catid')->comment('分类ID');
            $table->string('title')->comment('标题');
            $table->string('introduce')->comment('简介');
            $table->string('tag')->comment('标签');
            $table->longText('content')->comment('详情');
            $table->string('thumb')->comment('标题图片');
            $table->string('username')->comment('发布人');
            $table->unsignedInteger('comment')->comment('评论数量');
            $table->unsignedInteger('zan')->comment('赞数量');
            $table->unsignedBigInteger('hits')->comment('点击量');
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
        Schema::drop('articles');
    }
}
