<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tag' , function(Blueprint $table){
            $table->increments('id');
            $table->string('name')->comment('标签名称');
            $table->unsignedInteger('items')->default(0)->comment('文章数量');
            $table->unsignedInteger('addtime')->comment('添加时间');
            $table->unsignedTinyInteger('status')->default(0)->comment('状态');
        });
        Schema::create('tag_record' ,function (Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('aid')->comment('文章ID');
            $table->unsignedInteger('tid')->comment('标签ID');
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
