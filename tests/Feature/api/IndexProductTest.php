<?php

namespace Tests\Feature\api;

use Database\Factories\CategoryFactory;
use Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class IndexProductTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    /**
     * test to verify that the response is json
     *
     * @test
     * @return void
     */
    public function itReturnAJsonResponse(): void
    {
        $response = $this->getJson(route('api.product.index'));

        $response->assertStatus(200);
    }

    /**
     * test to verify that the response is an array of products
     *
     * @test
     * @return void
     */
    public function returnAnArrayOfProduct(): void
    {
        CategoryFactory::new()->create();
        $product = ProductFactory::new()->create();

        $response = $this->getJson(route('api.product.index'));

        $response->assertJson([
            [
                'name' => $product->name,
                'slug' => $product->slug,
                'category_id' => $product->category_id,
                'quantity' => $product->quantity,
                'price' => $product->price,
                'description' => $product->description,
                'specifications' => $product->specifications,
                'data_of_interest' => $product->data_of_interest,
                'status' => $product->status,
            ]
        ]);
    }
}
