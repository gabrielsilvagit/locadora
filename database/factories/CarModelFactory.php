<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Brand;
use App\CarModel;
use Faker\Generator as Faker;

$factory->define(CarModel::class, function (Faker $faker) {
    $brand=factory(Brand::class)->create();

    return [
        'name' => $faker->name,
        'brand_id' => $brand->id
    ];
});
