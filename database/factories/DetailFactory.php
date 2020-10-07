<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\MercatodoModels\Detail;
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

$factory->define(Detail::class, function (Faker $faker) {
    return [
        'quantity' => '2',
        'products_id' => '1',
        'order_id' => '1',
    ];
});
