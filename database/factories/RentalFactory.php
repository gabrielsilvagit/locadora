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
    $vehicle = factory(Vehicle::class)->create();
    $category = Category::find($vehicle->category_id);

    $start = rand(0, 1000);
    $end = $start-5;

    return [
        "start_date" => Carbon::today()->subDays($start),
        "end_date" => Carbon::today()->subDays($end),
        "category_id" => $category->id,
        "notes" => $faker->text,
        "free_km" => false,
    ];
});
$factory->state(Rental::class, 'forMake', function (Faker $faker) {

    return [
        "under_25" => false
    ];
});

$factory->state(Rental::class, 'forCreate', function (Faker $faker) {
    $user = factory(User::class)->create();
    $vehicle = factory(Vehicle::class)->create();
    $setting = factory(Setting::class)->create();
    $category = Category::find($vehicle->category_id);

    return [
        "user_id" => $user->id,
        "type" => "rent",
        "daily_rate" => $category->daily_rate,
        "age_aditional" => $setting->age_aditional
    ];
});
