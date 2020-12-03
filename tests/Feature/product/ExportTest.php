<?php

namespace Tests\Feature\product;

use Database\Factories\CategoryFactory;
use Database\Factories\PermissionFactory;
use Database\Factories\ProductFactory;
use Database\Factories\RoleFactory;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class ExportTest extends TestCase
{
    use RefreshDatabase;
    /**
     * test to verify that a user is authenticated to export product
     *
     * @test
     * @return void
     */
    public function aUserNotAuthenticatedCanExportProduct(): void
    {
        CategoryFactory::new()->create();
        ProductFactory::new()->create();

        Excel::fake();
        $this->get(route('products.export', ['extension' => 'xlsx']))
            ->assertRedirect(route('login'));
    }

    /**
     * test to verify if the user has permissions
     *
     * @test
     * @return void
     */
    public function anUnauthorizedUserCanExportProduct(): void
    {
        CategoryFactory::new()->create();
        ProductFactory::new()->create();
        $user = UserFactory::new()->create();

        Excel::fake();

        $this->actingAs($user)->get(route('products.export', ['extension' => 'xlsx']))
            ->assertStatus(403);
    }

    /**
     * test to verify if an authorized user can export product
     *
     * @test
     * @return void
     */
    public function anAuthorizedUserCanExportProduct(): void
    {
        CategoryFactory::new()->create();
        ProductFactory::new()->create();
        $permission = PermissionFactory::new()->create([
            'slug' => 'products.export'
        ]);
        $roladmin = RoleFactory::new()->create([
            'full-access' => 'yes'
        ]);
        $user = UserFactory::new()->create();

        $user->roles()->sync([$roladmin->id]);
        $roladmin->permissions()->sync($permission->id);

        Excel::fake();

        $this->actingAs($user)->from(route('admin.product.index'))
            ->get(route('products.export', ['extension' => 'xlsx']))
            ->assertRedirect(route('admin.product.index'));
    }
}
