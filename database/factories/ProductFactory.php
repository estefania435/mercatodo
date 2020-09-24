<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\MercatodoModels\Category;
use App\MercatodoModels\Product;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->text(20),
        'slug' => $faker->text(20),
        'category_id'=> Category::all()->first(),
        'quantity'=> '20',
        'price'=> '5000',
        'description'=> $faker->text(150),
        'specifications'=> $faker->text(150),
        'data_of_interest'=> $faker->text(150),
        'status'=> 'New',
    ];
});
