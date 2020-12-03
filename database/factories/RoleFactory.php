<?php

namespace database\factories;

use App\MercatodoModels\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Role::class;

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
            'full-access' => $this->faker->text(20),
        ];
    }
}
