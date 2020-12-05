<?php

namespace Tests\Feature\product;

use Database\Factories\PermissionFactory;
use database\factories\RoleFactory;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Database\Factories\CategoryFactory;

class ImportTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    /**
     * test to verify that an authorized person can import products
     *
     *
     * @return void
     */
    /*public function itCanImportProducts(): void
    {
        CategoryFactory::new()->create([
            'name' => 'perros'
        ]);
        $permission = PermissionFactory::new()->create([
            'slug' => 'products.import'
        ]);
        $roladmin = RoleFactory::new()->create([
            'full-access' => 'yes'
        ]);
        $user = UserFactory::new()->create();

        $user->roles()->sync([$roladmin->id]);
        $roladmin->permissions()->sync($permission->id);

        $importFile = $this->getUploadedFile('products.xlsx');

        $this->actingAs($user)->post($this->getRoute(), ['importFile' => $importFile]);
    }*/

    /**
     * test to verify that products are not imported if they do not meet validations
     *
     * @test
     * @return void
     */
    public function itCannotImportProductsDueValidationErrors(): void
    {
        CategoryFactory::new()->create([
            'name' => 'perros'
        ]);
        $permission = PermissionFactory::new()->create([
            'slug' => 'products.import'
        ]);
        $roladmin = RoleFactory::new()->create([
            'full-access' => 'yes'
        ]);
        $user = UserFactory::new()->create();

        $user->roles()->sync([$roladmin->id]);
        $roladmin->permissions()->sync($permission->id);
        $importFile = $this->getUploadedFile('productsnot.xlsx');

        $response = $this->actingAs($user)->post($this->getRoute(), ['importFile' => $importFile]);

        $response->assertSessionHasErrors();
        $this->assertDatabaseCount('products', 0);
    }

    /**
     * function for define to route
     *
     *
     * @return string
     */
    private function getRoute(): string
    {
        return route('products.import');
    }

    /**
     * function for define the archive
     *
     * @param string $fileName
     * @return uploadedFile
     */
    private function getUploadedFile(string $fileName): uploadedFile
    {
        $filePath = base_path('tests/stubs/' . $fileName);

        return new UploadedFile($filePath, 'products.xlsx', null, null, true);
    }
}
