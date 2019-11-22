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
            $table->bigInteger('category_id')->unsigned();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->float('daily_rate');
            $table->string('notes');
            $table->string('current_km')->nullable();
            $table->string('fuel_level')->nullable();
            $table->integer('limited');
            $table->string('plate')->nullable();
            $table->integer('age_aditional')->nulllable();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('category_id')->references('id')->on('categories');
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
