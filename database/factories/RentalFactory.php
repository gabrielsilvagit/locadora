<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Rental;
use App\Vehicle;
use App\Category;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Rental::class, function (Faker $faker) {
    $user = factory(User::class)->create();
    $vehicle = factory(Vehicle::class)->create();
    $category = Category::find($vehicle->category_id);
    $type_array = ['Manutenção', 'Limpeza', 'Aluguel'];
    shuffle($type_array);
    $start = rand(0,1000);
    $end = $start-5;
    return [
        'type' => $type_array[0],
        'user_id' => $user->id,
        'category_id' => $category->id,
        'start_date' => Carbon::today()->subDays($start),
        'end_date' => Carbon::today()->subDays($end),
        'daily_rate' => rand(0,500),
        'notes' => $faker->text,
        'current_km' => rand(0,1000000),
        'fuel_level' => rand(0,8),
        'limited' => $faker->boolean($chanceOfGettingTrue = 50)
    ];
});
