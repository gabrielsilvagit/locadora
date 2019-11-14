<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type'); // m = manutencao, l = limpeza, a = aluguel
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('vehicle_id')->unsigned();
            $table->date('start_date');
            $table->date('end_date');
            $table->float('daily_rate');
            $table->string('notes');
            $table->string('current_km');
            $table->string('fuel_level');
            $table->integer('limited');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('vehicle_id')->references('id')->on('vehicles');
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
        Schema::dropIfExists('rentals');
    }
}
