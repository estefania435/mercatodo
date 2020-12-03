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

class DeleteProductTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    /**
     * test to verify if the user has permissions
     *
     * @test
     * @return void
     */
    public function anUnauthorizedUserCanDeleteProduct(): void
    {
        $user = UserFactory::new()->create();
        CategoryFactory::new()->create();
        $product = ProductFactory::new()->create();

        $this->actingAs($user)->deleteJson(route('api.product.delete', $product->id))
            ->assertStatus(403);
    }
    /**
     * test to verify if an authorized user can delete a product
     *
     * @test
     * @return void
     */
    public function anAuthorizeUserCanDeleteProduct(): void
    {
        $permission = PermissionFactory::new()->create([
            'slug' => 'admin.product.destroy'
        ]);
        $roladmin = RoleFactory::new()->create([
            'full-access' => 'yes'
        ]);
        $user = UserFactory::new()->create();
        $user->roles()->sync([$roladmin->id]);
        $roladmin->permissions()->sync($permission->id);
        $c = CategoryFactory::new()->create();
        $product = ProductFactory::new()->create();

        $response = $this->actingAs($user)->deleteJson(route('api.product.delete', $product->id));

        $response->assertStatus(200);

    }
}
