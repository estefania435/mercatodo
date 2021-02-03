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

class ShowProductTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    /**
     * test to verify if the user has permissions
     *
     * @test
     * @return void
     */
    public function anUnauthorizedUserCanShowProduct(): void
    {
        CategoryFactory::new()->create();
        $product = ProductFactory::new()->create();
        $user = UserFactory::new()->create();

        $this->actingAs($user)->getJson(route('api.product.show', $product->id))
            ->assertStatus(403);
    }
    /**
     * test to verify if an authorized user can show a product
     *
     * @test
     * @return void
     */
    public function anAuthorizeUserCanShowProduct(): void
    {
        CategoryFactory::new()->create();
        $product = ProductFactory::new()->create();
        $permission = PermissionFactory::new()->create([
            'slug' => 'admin.product.show'
        ]);
        $roladmin = RoleFactory::new()->create([
            'full-access' => 'yes'
        ]);
        $user = UserFactory::new()->create();
        $user->roles()->sync([$roladmin->id]);
        $roladmin->permissions()->sync($permission->id);

        $response = $this->actingAs($user)->getJson(route('api.product.show', $product->id));

        $response->assertStatus(200);
    }
}
