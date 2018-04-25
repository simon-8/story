<?php
/*
 * 微信聊天记录表
 * */
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeixinChatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weixin_chat' , function(Blueprint $table){
            $table->increments('id');
            $table->string('openid')->comment('用户openid');
            $table->string('type')->comment('消息类型');
            $table->unsignedTinyInteger('subscribe')->comment('是否订阅')->default(0);
            $table->text('content')->comment('内容');
            $table->text('misc')->comment('原内容');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('weixin_chat');
    }
}
