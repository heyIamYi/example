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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('後臺列表標題');
            $table->integer('parent_id')->comment('上一層id')->default(0);
            $table->string('alias')->nullable()->comment('別名');
            $table->integer('sort')->comment('排序')->default(100);
            $table->integer('hide_sub')->default(0);
            $table->integer('slist')->comment('列表')->default(1);
            $table->integer('sadd')->comment('新增')->default(1);
            $table->integer('sedit')->comment('編輯')->default(1);
            $table->integer('sdelete')->comment('刪除')->default(1);
            $table->integer('control')->default(1);
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
        Schema::dropIfExists('menus');
    }
};
