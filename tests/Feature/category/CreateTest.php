<?php

namespace Tests\Feature\category;

use App\MercatodoModels\Category;
use App\MercatodoModels\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function aUserCanViewCategories()
    {
        $response = $this->get(route('admin.category.index'));

        $response->assertRedirect('login');
    }

    /** @test */
    /*public function aUserCanCreateCategories()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->get(route('admin.category.create'));

        $response->assertOk();
    }*/
}
