<?php

namespace App\Imports;

use App\Concerns\ProductValidations;
use App\MercatodoModels\Category;
use App\MercatodoModels\Image;
use App\MercatodoModels\Product;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;
    use ProductValidations;

    /**
     *Import products and images
     *
    * @param array $row
    *
    * @return void
    */
    public function model(array $row): void
    {
        $category = Category::where('name', $row['category'])->first();

        $products = Product::where('name', $row['name'])->first();


        if ($products) {
            $products->slug = $row['name'];
            $products->category_id = $category->id;
            $products->quantity = $row['quantity'];
            $products->price = $row['price'];
            $products->description = $row['description'];
            $products->specifications = $row['specifications'];
            $products->data_of_interest = $row['data'];
            $products->status = $row['status'];
            $products->save();

            $this->createimage($products, $row['image']);
        } else {
            $product = new Product();
            $product->name = $row['name'];
            $product->slug = $row['name'];
            $product->category_id = $category->id;
            $product->quantity = $row['quantity'];
            $product->price = $row['price'];
            $product->description = $row['description'];
            $product->specifications = $row['specifications'];
            $product->data_of_interest = $row['data'];
            $product->status = $row['status'];
            $product->save();

            $this->createimage($product, $row['image']);
        }
    }

    /**
     *import images for products import
     *
     * @param object $products
     * @param string $rowImagen
     * @return void
     */
    private function createImage(object $products, string $rowImagen): void
    {

        $urlimages = [];
        if (!empty($rowImagen)) {
            foreach (explode(',', $rowImagen) as $image) {
                if (!empty($image)) {
                    $img = str_replace('/images/products/', '', trim($image, ' '));
                    $imagenFormat = '/images/products/' . $img;

                    $imageExist = Image::where('url', $imagenFormat)->where('imageable_id', $products->id)->first();

                    if (!$imageExist) {
                        $urlimages[]['url'] = $imagenFormat;
                    }
                }
            }
        }

        $products->images()->createMany($urlimages);
    }
}
