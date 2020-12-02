<?php

namespace Tests\Feature\product;

use App\Exports\ProductExport;
use App\Jobs\NotifyUserOfCompletedReport;
use App\MercatodoModels\Category;
use App\MercatodoModels\Product;
use App\MercatodoModels\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\MercatodoModels\Permission;
use Maatwebsite\Excel\Facades\Excel;
use App\MercatodoModels\User;
use Illuminate\Support\Facades\Hash;

class ReportTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testaUserNotAuthenticatedCanGenerateReport()
    {
        $category = Category::create([
            'name' => 'perros',
            'slug' => 'perros',
            'description' => 'dfghfdsdfghfdsdfgfdsdfgdsdfgfdsdfgfdsdfgd'
        ]);
        Product::create([
            'name' => 'collar',
            'slug' => 'collar',
            'category_id' => $category->id,
            'quantity' => 32,
            'price' => 4000,
            'description' => 'dsfghfdsadfghfdsdfghfdsdfghfdsdfghfdsadfgdsd',
            'status' => 'New',
        ]);

        Excel::fake();
        $this->get(route('report.products', ['extension' => 'xlsx']))
            ->assertRedirect(route('login'));
    }
    public function testExample()
     {
         $category = Category::create([
             'name' => 'perros',
             'slug' => 'perros',
             'description' => 'dfghfdsdfghfdsdfgfdsdfgdsdfgfdsdfgfdsdfgd'
         ]);
         $permission = Permission::create
         (['name' => 'Generate report of products',
             'slug' => 'report.products',
             'description' => 'dsfghgfdsadfghjgfdsdfghjgfdsasdfghjgfdsasdfghgf']);
         $user = User::create([

             'name' => 'tefa',
             'surname' => 'Eladmin',
             'identification' => '1152221843',
             'address' => 'carrera 76 B # 54 38',
             'phone' => '3173015098',
             'email' => 'estefa@admin.com',
             'password' => Hash::make('1234567890'),
         ]);
         $roladmin = Role::create([
             'name' => 'Admin',
             'slug' => 'admin',
             'description' => 'Administrator',
             'full-access' => 'yes'

         ]);

         $user->roles()->sync([$roladmin->id]);
         $roladmin->permissions()->sync($permission->id);

         $product = Product::create([
             'name' => 'collar',
             'slug' => 'collar',
             'category_id' => $category->id,
             'quantity' => 32,
             'price' => 4000,
             'description' => 'dsfghfdsadfghfdsdfghfdsdfghfdsdfghfdsadfgdsd',
             'status' => 'New',
         ]);

         Excel::fake();

         $this->actingAs($user)->from(route('admin.product.index'))
             ->get(route('report.products', ['extension' => 'xlsx']))
             ->assertRedirect(route('admin.product.index'));
    }
}
