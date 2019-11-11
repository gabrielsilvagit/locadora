<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Faker\Provider\pt_BR\Person;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {

    $person = new Person($faker);

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('password'),
        'address' => $faker->address,
        'city' => $faker->city,
        'state' => $faker->state,
        'country' => $faker->country,
        'cpf' => $person->cpf(true),
        'dob' => $faker->date($format = 'd-m-Y', $max = '-18 years'),
        'cnh' => $person->rg(true),
        'admin' => $faker->boolean($chanceOfGettingTrue = 50)
    ];
});
