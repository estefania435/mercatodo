<?php

namespace Database\Factories;

use App\MercatodoModels\Order;
use App\MercatodoModels\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => 'ac3456',
            'total' => '200000',
            'user_id' => User::all()->random()->id,
            'name_receive' => $this->faker->name,
            'surname' => $this->faker->lastName,
            'address' => $this->faker->address,
            'phone' => User::all()->random()->phone,
        ];
    }
}
