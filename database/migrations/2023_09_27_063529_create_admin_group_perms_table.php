<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_group_perms', function (Blueprint $table) {
            $table->id();
            $table->integer('u_id')->nullable()->comment('使用者id');
            $table->integer('group_id')->nullable()->comment('群組id');
            $table->integer('menu_id')->comment('菜單的id');
            $table->tinyinteger('s_tag')->nullable();
            $table->tinyinteger('a_tag')->nullable();
            $table->tinyinteger('e_tag')->nullable();
            $table->tinyinteger('d_tag')->nullable();
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
        Schema::dropIfExists('admin_group_perms');
    }
};
