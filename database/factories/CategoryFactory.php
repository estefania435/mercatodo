<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\MercatodoModels\Category;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->text(20),
        'slug' => $faker->text(20),
        'description' => $faker->text(150),
    ];
});
