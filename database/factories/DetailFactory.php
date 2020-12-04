<?php

namespace Database\Factories;

use App\MercatodoModels\Detail;
use App\MercatodoModels\Order;
use App\MercatodoModels\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class DetailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Detail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'quantity' => 1,
            'products_id' => Product::all()->random()->id,
            'unit_price' => Product::all()->random()->price,
            'order_id' => Order::all()->random()->id,
        ];
    }
}
