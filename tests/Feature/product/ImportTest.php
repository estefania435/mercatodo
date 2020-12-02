<?php

namespace Tests\Feature\product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\MercatodoModels\Category;
use Database\Factories\CategoryFactory;

class ImportTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testItCanImportProducts()
    {

        $c = new Category();
        $c->name = 'perros';
        $c->slug = 'perros';
        $c->description = 'ghjkvghjhgfdfghjhgfdfghjhgfdsdfghj';
        $c->save();

        $importFile = $this->getUploadedFile('products.xlsx');

        $response = $this->post($this->getRoute(), ['importFile' => $importFile]);

        $this->assertDatabaseHas('products', [
            'name' => 'paseador'
        ]);

        $response->assertRedirect(route('admin.product.index'));
    }

    public function testItCannotProductsDueValidationErrors()
    {
        $c = new Category();
        $c->name = 'perros';
        $c->slug = 'perros';
        $c->description = 'ghjkvghjhgfdfghjhgfdfghjhgfdsdfghj';
        $c->save();
        $importFile = $this->getUploadedFile('productsnot.xlsx');

        $response = $this->post($this->getRoute(), ['importFile' => $importFile]);


        $response->assertSessionHasErrors();
        $this->assertDatabaseCount('products', 0);

    }

    private function getRoute(): string
    {
        return route('products.import');
    }

    private function getUploadedFile(string $fileName): uploadedFile
    {
        $filePath = base_path('tests/stubs/' . $fileName);

        return new UploadedFile($filePath, 'products.xlsx', null, null, true);
    }
}
