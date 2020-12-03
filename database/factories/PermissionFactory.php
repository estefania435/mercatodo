<?php

namespace Database\Factories;

use App\MercatodoModels\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;

class PermissionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Permission::class;

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
            'description' => $this->faker->text(150),
        ];
    }
}
