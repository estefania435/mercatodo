<?php

namespace Tests\Feature\Category;

use App\MercatodoModels\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function aUserCanListCategories()
    {

        $response = $this->get(route('admin.category.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.category.index');
        $response->assertViewHas('categories');

        $responseCategories = $response->getOriginalContent()['categories'];
    }


}
