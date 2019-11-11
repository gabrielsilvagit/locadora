<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('plate');
            $table->string('chassi')->unique();
            $table->bigInteger('carmodel_id')->unsigned();
            $table->bigInteger('fuel_id')->unsigned();
            $table->bigInteger('category_id')->unsigned();
            $table->date('model_year');
            $table->date('make_year');

            $table->foreign('carmodel_id')->references('id')->on('carmodels');
            $table->foreign('fuel_id')->references('id')->on('fuels');
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
        Schema::dropIfExists('vehicles');
    }
}
