<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\MercatodoModels\Detail;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

$factory->define(Detail::class, function (Faker $faker) {
    return [
        'quantity' => '2',
        'products_id' => '1',
        'order_id' => '1',
    ];
});
