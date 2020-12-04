<?php

namespace Tests\Feature\product;

use Database\Factories\CategoryFactory;
use Database\Factories\PermissionFactory;
use Database\Factories\ProductFactory;
use database\factories\RoleFactory;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Maatwebsite\Excel\Facades\Excel;

class ReportTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test to verify that a user is authenticated to generate a report
     *
     * @test
     * @return void
     */
    public function aUserNotAuthenticatedCanGenerateReport(): void
    {
        CategoryFactory::new()->create([
            'name' => 'perros'
        ]);
        ProductFactory::new()->create();

        Excel::fake();
        $this->get(route('report.products', ['extension' => 'xlsx']))
            ->assertRedirect(route('login'));
    }

    /**
     * test to verify if the user has permissions
     *
     * @test
     * @return void
     */
    public function anUnauthorizedUserCanGenerateProductReports(): void
    {
        CategoryFactory::new()->create([
            'name' => 'perros'
        ]);
        ProductFactory::new()->create();
        $user = UserFactory::new()->create();
        Excel::fake();

        $this->actingAs($user)->get(route('report.products', ['extension' => 'xlsx']))
            ->assertStatus(403);
    }

    /**
     * test to verify if an authorized user can generate report of products
     *
     * @test
     * @return void
     */
    public function anAuthorizedUserCanGenerateProductReports(): void
    {
         CategoryFactory::new()->create();
         ProductFactory::new()->create();
         $permission = PermissionFactory::new()->create([
             'slug' => 'report.products'
         ]);
         $roladmin = RoleFactory::new()->create([
             'full-access' => 'yes'
         ]);
         $user = UserFactory::new()->create();
         $user->roles()->sync([$roladmin->id]);
         $roladmin->permissions()->sync($permission->id);
         Excel::fake();

         $this->actingAs($user)->from(route('admin.product.index'))
             ->get(route('report.products', ['extension' => 'xlsx']))
             ->assertRedirect(route('admin.product.index'));
    }
}
