<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\MercatodoModels\Order;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

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
