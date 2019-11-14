<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Vehicle;
use App\CarModel;
use App\Fuel;
use App\Category;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Vehicle::class, function (Faker $faker) {
    $carmodel = factory(CarModel::class)->create();
    $fuel = factory(Fuel::class)->create();
    $category = factory(Category::class)->create();
    return [
        'plate' => Str::random(),
        'chassi' => Str::random(),
        'carmodel_id' => $carmodel->id,
        'fuel_id' => $fuel->id,
        'category_id' => $category->id,
        'model_year' => $faker->year,
        'make_year' => $faker->year,
    ];
});
