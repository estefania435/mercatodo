<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\MercatodoModels\Category;
use App\MercatodoModels\Product;
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

/**
 * @param Faker $faker
 * @return array
 */
$factory->define(Product::class, function (Faker $faker): array {
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
