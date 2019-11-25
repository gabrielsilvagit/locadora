<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CheckOut;
use Faker\Generator as Faker;

$factory->define(CheckOut::class, function (Faker $faker) {
    $rental = factory(Rental::class)->states('forCreate')->create();
    return [

    ];
});
