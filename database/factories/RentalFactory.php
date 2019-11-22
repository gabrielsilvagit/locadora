<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Rental;
use App\Setting;
use App\Vehicle;
use App\Category;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Rental::class, function (Faker $faker) {
    $user = factory(User::class)->create();
    $vehicle = factory(Vehicle::class)->create();
    $setting = factory(Setting::class)->create();
    $category = Category::find($vehicle->category_id);
    $start = rand(0, 1000);
    $end = $start-5;

    return [
        "category_id" => $category->id,
        "start_date" => Carbon::today()->subDays($start),
        "end_date" => Carbon::today()->subDays($end),
        "notes" => $faker->text,
        "free_km" => $faker->boolean($chanceOfGettingTrue = 50),
        "under_25" => $faker->boolean($chanceOfGettingTrue = 50)
    ];
});
