<?php

namespace Tests\Feature\order;

use Database\Factories\CategoryFactory;
use Database\Factories\DetailFactory;
use Database\Factories\OrderFactory;
use Database\Factories\PermissionFactory;
use Database\Factories\ProductFactory;
use database\factories\RoleFactory;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class ReportOrderTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test to verify that a user is authenticated to generate a report
     *
     * @test
     * @return void
     */
    public function aUserNotAuthenticatedCanGenerateOrderReport(): void
    {
        CategoryFactory::new()->create();
        ProductFactory::new()->create();
        UserFactory::new()->create();
        OrderFactory::new()->create();
        DetailFactory::new()->create();

        Excel::fake();
        $this->get(route('report.orders', ['extension' => 'xlsx']))
            ->assertRedirect(route('login'));
    }

    /**
     * test to verify if the user has permissions
     *
     * @test
     * @return void
     */
    public function anUnauthorizedUserCanGenerateOrderReport(): void
    {
        CategoryFactory::new()->create();
        ProductFactory::new()->create();
        $user = UserFactory::new()->create();
        OrderFactory::new()->create();
        DetailFactory::new()->create();
        Excel::fake();

        $this->actingAs($user)->get(route('report.orders', ['extension' => 'xlsx']))
            ->assertStatus(403);
    }

    /**
     * test to verify if an authorized user can generate report of order
     *
     * @test
     * @return void
     */
    public function anAuthorizedUserCanGenerateOrderReport(): void
    {
        $permission = PermissionFactory::new()->create([
            'slug' => 'report.orders'
        ]);
        CategoryFactory::new()->create();
        ProductFactory::new()->create();
        $user = UserFactory::new()->create();
        OrderFactory::new()->create();
        DetailFactory::new()->create();
        $roladmin = RoleFactory::new()->create([
            'full-access' => 'yes'
        ]);

        $user->roles()->sync([$roladmin->id]);
        $roladmin->permissions()->sync($permission->id);
        Excel::fake();

        $this->actingAs($user)->from(route('admin.order.index'))
            ->get(route('report.orders', ['extension' => 'xlsx']))
            ->assertRedirect(route('admin.order.index'));
    }
}
