<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'roles' , function(Blueprint $table){
            $table->increments('itemid');
            $table->string('user')->comment('用户名');
            $table->string('username')->comment('用户名');
        });
        Schema::create( 'premisssion' , function(Blueprint $table){

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
