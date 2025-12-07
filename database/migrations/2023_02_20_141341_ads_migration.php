<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        //
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->string('place');
            $table->string('days');
            $table->string('night');
            $table->string('person');
            $table->string('price');
            $table->string('meal');
            $table->string('bonfire');
            $table->string('tourguide');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('ads');
    }
};
