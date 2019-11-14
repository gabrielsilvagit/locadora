<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Rental;
use App\Vehicle;
use Faker\Generator as Faker;

$factory->define(Rental::class, function (Faker $faker) {
    $user = factory(User::class)->create();
    $vehicle = factory(Vehicle::class)->create();
    $type_array = ['Manutenção', 'Limpeza', 'Aluguel'];
	shuffle($type_array);
    return [
        'type' => $type_array[0],
        'user_id' => $user->id,
        'vehicle_id' => $vehicle->id,
        'start_date' => $faker->date($format = 'd-m-Y'),
        'end_date' => $faker->date($format = 'd-m-Y'),
        'daily_rate' => rand(0,500),
        'notes' => $faker->text,
        'current_km' => rand(0,1000000),
        'fuel_level' => rand(0,8),
        'limited' => $faker->boolean($chanceOfGettingTrue = 50)
    ];
});
