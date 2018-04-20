<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rule_group', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('角色名称');
            $table->string('access')->comment('权限');
            $table->unsignedTinyInteger('status')->default(0)->comment('状态');
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
