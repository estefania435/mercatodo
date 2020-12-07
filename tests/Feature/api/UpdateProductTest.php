<?php

namespace Tests\Feature\api;

use Database\Factories\CategoryFactory;
use Database\Factories\PermissionFactory;
use Database\Factories\ProductFactory;
use database\factories\RoleFactory;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class UpdateProductTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    /**
     * test to verify if the user has permissions
     *
     * @test
     * @return void
     */
    public function anUnauthorizedUserCanUpdateProduct(): void
    {
        $user = UserFactory::new()->create();
        $c = CategoryFactory::new()->create();
        $p = ProductFactory::new()->create();

        $product = ([
            'name' => 'collar',
            'slug' => 'collar',
            'category_id' => $c->name,
            'quantity' => 89,
            'price' => 4000,
            'description' => 'kjbvbnklcvbnmcvhjhgfmnbvcxvbnmnbvcx',
            'specifications' => 'sdfghjkhgfdsfghjkjhgfdsdfghjkhgfdsdfg',
            'data_of_interest' => 'sdfghjkhgfdssdfghjkhgfcxzcvbnhjk',
            'status' => 'New',
            'url' => '/images/products/mochila-transparente-para-mascotas-1.jpg',
            'imageable_type' => 'App\MercatodoModels\Product'
        ]);

        $this->actingAs($user)->putJson(route('api.product.update', $p->slug), $product)->assertStatus(403);
    }
    /**
     * test to verify if an authorized user can update a product
     *
     * @test
     * @return void
     */
    public function anAuthorizeUserCanUpdateProduct(): void
    {
        $permission = PermissionFactory::new()->create([
            'slug' => 'admin.product.update'
        ]);
        $roladmin = RoleFactory::new()->create([
            'full-access' => 'yes'
        ]);
        $user = UserFactory::new()->create();
        $user->roles()->sync([$roladmin->id]);
        $roladmin->permissions()->sync($permission->id);
        $c = CategoryFactory::new()->create();
        $p = ProductFactory::new()->create();

        $product = ([
            'name' => 'collar',
            'slug' => 'collar',
            'category_id' => $c->name,
            'quantity' => 89,
            'price' => 4000,
            'description' => 'kjbvbnklcvbnmcvhjhgfmnbvcxvbnmnbvcx',
            'specifications' => 'sdfghjkhgfdsfghjkjhgfdsdfghjkhgfdsdfg',
            'data_of_interest' => 'sdfghjkhgfdssdfghjkhgfcxzcvbnhjk',
            'status' => 'New',
            'url' => '/images/products/mochila-transparente-para-mascotas-1.jpg',
            'imageable_type' => 'App\MercatodoModels\Product'
        ]);

        $response = $this->actingAs($user)->putJson(route('api.product.update', $p->slug), $product);
        $response->assertStatus(200);
    }
}
