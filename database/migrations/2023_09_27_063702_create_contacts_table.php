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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('姓名');
            $table->string('tel')->comment('電話');
            $table->string('email')->comment('信箱');
            $table->string('company')->comment('服務單位');
            $table->text('content')->comment('聯絡內容');
            $table->string('state')->nullable()->comment('處理狀態');
            $table->string('remark')->nullable()->comment('備註說明');
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
        Schema::dropIfExists('contacts');
    }
};
