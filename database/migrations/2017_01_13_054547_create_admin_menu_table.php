<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_menus' , function(Blueprint $table){
            $table->increments('itemid');
            $table->unsignedSmallInteger('pid')->comment('父ID');
            $table->string('name')->comment('菜单名称');
            $table->string('control')->comment('控制器名称');
            $table->string('func')->comment('方法名称');
            $table->string('ico')->comment('图标名称');
            $table->unsignedSmallInteger('listorder')->comment('排序');
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
