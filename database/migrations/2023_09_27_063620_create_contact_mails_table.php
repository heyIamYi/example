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
        Schema::create('contact_mails', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->comment('名稱');
            $table->string('email')->nullable()->comment('聯絡信箱');
            $table->string('phone')->nullable()->comment('聯絡電話');
            $table->string('address')->nullable()->comment('聯絡地址');
            $table->integer('sort')->default('100')->comment('排序');
            $table->integer('is_show')->nullable()->comment('是否啟用');
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
        Schema::dropIfExists('contact_mails');
    }
};
