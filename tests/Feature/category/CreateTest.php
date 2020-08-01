<?php

namespace Tests\Feature\Category;

use App\MercatodoModels\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function aUserCanViewFormCreateCategories()
    {
        $response = $this->get(route('admin.category.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.category.create');

    }
}
