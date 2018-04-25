<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleAccessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_access', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pid')->comment('上级权限');
            $table->string('name')->comment('权限名称');
            $table->string('path')->comment('权限路径');
            //$table->name
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('role_access');
    }
}
