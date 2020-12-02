<?php

namespace Database\Factories;

use App\MercatodoModels\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Category::class;

    /**
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->text(20),
            'slug' => $this->faker->text(20),
            'description' => $this->faker->text(150),
        ];
    }
}
