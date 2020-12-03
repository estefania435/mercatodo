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

class RestoreProductTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    /**
     * test to verify if the user has permissions
     *
     * @test
     * @return void
     */
    public function anUnauthorizedUserCanRestoreProduct(): void
    {
        $user = UserFactory::new()->create();
        $c = CategoryFactory::new()->create();
        $p = ProductFactory::new()->create();
        $product = ([
            'name' => 'collar',
            'slug' => 'collar',
            'category_id' => $c->id,
            'quantity' => 89,
            'price' => 4000,
            'description' => 'kjbvbnklcvbnmcvhjhgfmnbvcxvbnmnbvcx',
            'specifications' => 'sdfghjkhgfdsfghjkjhgfdsdfghjkhgfdsdfg',
            'data_of_interest' => 'sdfghjkhgfdssdfghjkhgfcxzcvbnhjk',
            'status' => 'New',
            'deleted_at' => '2020-12-02 23:38:52',
            'url' => '/images/products/arenero2.jpeg',
            'imageable_type' => 'App\MercatodoModels\Product'
        ]);

        $this->actingAs($user)->postJson(route('api.product.restore', $p->id), $product)
            ->assertStatus(403);

    }
    /**
     * test to verify if an authorized user can restore a product
     *
     * @test
     * @return void
     */
    public function anAuthorizeUserCanRestoreProduct(): void
    {
        $permission = PermissionFactory::new()->create([
            'slug' => 'api.product.restore'
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
            'category_id' => $c->id,
            'quantity' => 89,
            'price' => 4000,
            'description' => 'kjbvbnklcvbnmcvhjhgfmnbvcxvbnmnbvcx',
            'specifications' => 'sdfghjkhgfdsfghjkjhgfdsdfghjkhgfdsdfg',
            'data_of_interest' => 'sdfghjkhgfdssdfghjkhgfcxzcvbnhjk',
            'status' => 'New',
            'deleted_at' => '2020-12-02 23:38:52',
            'url' => '/images/products/arenero2.jpeg',
            'imageable_type' => 'App\MercatodoModels\Product'
        ]);

        $response = $this->actingAs($user)->postJson(route('api.product.restore', $p->id), $product);

        $response->assertStatus(200);

    }
}
