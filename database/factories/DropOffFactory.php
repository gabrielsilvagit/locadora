<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Rental;
use App\DropOff;
use Faker\Generator as Faker;

$factory->define(DropOff::class, function (Faker $faker) {
    $rental = factory(Rental::class)->create();

    return [
        'damage' => $faker->boolean($chanceOfGettingTrue = 50),
        'damage_notes' => $faker->text,
        'clean' => $faker->boolean($chanceOfGettingTrue = 50),
        'clean_notes' => $faker->text,
        'fuel_level' => rand(0, 8),
        'current_km' => rand($rental->current_km, $rental->current_km + 500),
        'rental_id' => $rental->id
    ];
});
