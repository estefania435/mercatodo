<?php

namespace Database\Factories;

use App\MercatodoModels\Category;
use App\MercatodoModels\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->text(20),
            'slug' => $this->faker->text(20),
            'category_id' => Category::all()->first(),
            'quantity' => '20',
            'price' => '5000',
            'description' => $this->faker->text(150),
            'specifications' => $this->faker->text(150),
            'data_of_interest' => $this->faker->text(150),
            'status' => 'New',
        ];
    }
}
