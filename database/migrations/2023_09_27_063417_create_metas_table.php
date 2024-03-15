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
        Schema::create('metas', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('標題');
            $table->string('page_title')->nullable()->comment('SEO-標題');
            $table->string('meta_keywords')->nullable()->comment('SEO-關鍵字');
            $table->string('meta_description')->nullable()->comment('SEO-描述語');
            $table->text('page_script')->nullable()->comment('SEO-語法');
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
        Schema::dropIfExists('metas');
    }
};
