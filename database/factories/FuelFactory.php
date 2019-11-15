<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Fuel;
use Faker\Generator as Faker;

$factory->define(Fuel::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'price' => rand(5,15)
    ];
});
