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
            $table->increments('id');
            $table->unsignedSmallInteger('pid')->comment('父ID');
            $table->string('name')->comment('菜单名称');
            $table->string('prefix')->comment('路由前缀');
            $table->string('route')->comment('详细路由');
            $table->string('ico')->comment('图标名称');
            $table->unsignedSmallInteger('listorder')->comment('排序');
            $table->unsignedTinyInteger('items')->comment('子分类数量');
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
