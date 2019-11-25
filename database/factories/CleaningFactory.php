<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Vehicle;
use App\Cleaning;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Cleaning::class, function (Faker $faker) {
    $vehicle = factory(Vehicle::class)->create();

    return [
        "start_date" => Carbon::today(),
        "end_date" => Carbon::today()->addDay(),
        "category_id" => $vehicle->category_id,
        "notes" => $faker->text,
        'plate' => $vehicle->plate
    ];
});
