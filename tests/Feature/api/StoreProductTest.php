<?php

namespace Tests\Feature\api;

use App\MercatodoModels\Product;
use Database\Factories\CategoryFactory;
use Database\Factories\PermissionFactory;
use Database\Factories\ProductFactory;
use database\factories\RoleFactory;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class StoreProductTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    use WithoutMiddleware;

    /**
     * test to verify that the response is json
     *
     * @test
     * @return void
     */
    public function itReturnAJsonResponse(): void
    {
        $response = $this->getJson(route('api.product.store'));

        $response->assertStatus(200);
    }

    /**
     * test to verify if the user has permissions
     *
     * @test
     * @return void
     */
    public function anUnauthorizedUserCanStoreProduct(): void
    {
        $user = UserFactory::new()->create();
        $c = CategoryFactory::new()->create();
        $product = ([
            'name' => 'collar',
            'slug' => 'collar',
            'category_id' => $c->id,
            'quantity' => 2,
            'price' => 4000,
            'description' => 'kjbvbnklcvbnmcvhjhgfmnbvcxvbnmnbvcx',
            'specifications' => 'sdfghjkhgfdsfghjkjhgfdsdfghjkhgfdsdfg',
            'data_of_interest' => 'sdfghjkhgfdssdfghjkhgfcxzcvbnhjk',
            'status' => 'New',
            'url' => '/images/products/mochila-transparente-para-mascotas-1.jpg',
            'imageable_type' => 'App\MercatodoModels\Product'
        ]);

        $this->actingAs($user)->postJson(route('api.product.store'), $product)->assertStatus(403);

    }
    /**
     * test to verify if an authorized user can create a product
     *
     * @test
     * @return void
     */
    public function anAuthorizedUserCanStoreProduct(): void
    {
        $permission = PermissionFactory::new()->create([
            'slug' => 'admin.product.create'
        ]);
        $roladmin = RoleFactory::new()->create([
            'full-access' => 'yes'
        ]);
        $user = UserFactory::new()->create();
        $user->roles()->sync([$roladmin->id]);
        $roladmin->permissions()->sync($permission->id);
        $c = CategoryFactory::new()->create();
        $product = ([
            'name' => 'collar',
            'slug' => 'collar',
            'category_id' => $c->id,
            'quantity' => 2,
            'price' => 4000,
            'description' => 'kjbvbnklcvbnmcvhjhgfmnbvcxvbnmnbvcx',
            'specifications' => 'sdfghjkhgfdsfghjkjhgfdsdfghjkhgfdsdfg',
            'data_of_interest' => 'sdfghjkhgfdssdfghjkhgfcxzcvbnhjk',
            'status' => 'New',
            'url' => '/images/products/mochila-transparente-para-mascotas-1.jpg',
            'imageable_type' => 'App\MercatodoModels\Product'
        ]);

        $response = $this->actingAs($user)->postJson(route('api.product.store'), $product);

        $response->assertStatus(201);

        $this->assertEquals($product['name'], Product::first()->name);

    }
}
