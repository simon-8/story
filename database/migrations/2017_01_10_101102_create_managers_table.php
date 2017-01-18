<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('managers' ,function(Blueprint $table){
            $table->increments('id');
            $table->string('username',50)->comment('用户名');
            $table->string('password',60)->comment('密码');
            $table->string('truename',50)->comment('真实姓名');
            $table->string('email',100)->comment('邮箱号码');
            $table->string('salt',4)->comment('校验码');
            $table->string('lastip')->comment('上一次登录ip');
            $table->unsignedInteger('lasttime')->comment('最后登录时间');
            $table->rememberToken();//记住我
            $table->timestamps();//时间戳
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
