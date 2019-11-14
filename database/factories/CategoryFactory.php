<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'free_daily_rate' => rand(1,500),
        'daily_rate' => rand(1,500),
        'extra_km_price' => rand(1,500)
    ];
});
