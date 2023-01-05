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
        Schema::create('cloacks', function (Blueprint $table) {
            $table->id();
            $table->string('image_name');
            $table->string('size');
            $table->string('extension');
            $table->boolean('selected');
            $table->unsignedBigInteger('user_id');
            $table->unsignedbigInteger('profile_id');
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
        Schema::dropIfExists('cloacks');
    }
};
