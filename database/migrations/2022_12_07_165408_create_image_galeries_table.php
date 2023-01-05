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
        Schema::create('image_galeries', function (Blueprint $table) {
            $table->id();
            $table->text('name_image');
            $table->text('size');
            $table->text('extension');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('galery_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('galery_id')->references('id')->on('galeries')->onDelete('cascade');
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
        Schema::dropIfExists('image_galeries');
    }
};
