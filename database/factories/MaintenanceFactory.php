<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Setting;
use App\Vehicle;
use App\Category;
use Carbon\Carbon;
use App\Maintenance;
use Faker\Generator as Faker;

$factory->define(Maintenance::class, function (Faker $faker) {
    $vehicle = factory(Vehicle::class)->create();

    return [
        "start_date" => Carbon::today(),
        "category_id" => $vehicle->category_id,
        "notes" => $faker->text,
        'plate' => $vehicle->plate
    ];
});
