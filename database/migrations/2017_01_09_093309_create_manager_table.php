<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManagerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manager' , function(Blueprint $table){
            $table->increments('userid')->comment('用户ID');
            $table->string('username')->comment('用户名');
            $table->string('password')->comment('密码');
            $table->string('birthday')->comment('生日');
//            $table->string('addtime')->comment('添加时间');

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
