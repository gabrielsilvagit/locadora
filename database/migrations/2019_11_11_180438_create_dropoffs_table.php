<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDropoffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dropoffs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('damage');
            $table->string('damage_notes');
            $table->boolean('clean');
            $table->string('clean_notes');
            $table->string('fuel_level');
            $table->string('current_km');
            $table->bigInteger('rental_id')->unsigned();

            $table->foreign('rental_id')->references('id')->on('rentals');
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
        Schema::dropIfExists('dropoffs');
    }
}
