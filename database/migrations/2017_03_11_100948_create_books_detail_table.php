<?php
/*
 * 小说章节表
 * */
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'books_detail' , function(Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('pid')->comment('小说ID');
            $table->string('title')->comment('标题');
            //$table->Text('content')->comment('小说内容');
            $table->unsignedBigInteger('hits')->comment('浏览次数');
            $table->unsignedTinyInteger('status')->comment('状态');
            $table->string('fromurl')->comment('来源链接');
            $table->string('fromhash')->comment('来源链接hash值')->unique();
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
        Schema::drop('books_detail');
    }
}
