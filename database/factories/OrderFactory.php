<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\MercatodoModels\Order;
use Faker\Generator as Faker;

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

$factory->define(Order::class, function (Faker $faker) {
    return [
        'code' => 'ac3456',
        'total' => '200000',
        'user_id' => '1',
        'name_receive' => $faker->name,
        'surname' => $faker->lastName,
        'address' => $faker->address,
        'phone' => '3489768982',
    ];
});
