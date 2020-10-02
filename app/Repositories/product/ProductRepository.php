<?php

namespace App\Repositories\product;

use App\MercatodoModels\Category;
use App\MercatodoModels\Product;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ProductRepository extends BaseRepository
{
    /**
     * @return Product
     */
    public function getModel(): Product
    {
        return new Product();
    }

    /**
     * function for create product
     *
     * @param array $data
     */
    public function createProduct(object $data)
    {
        $urlimages = [];
        if ($data->hasFile('images')) {
            $images = $data->file('images');

            foreach ($images as $image) {
                $name = time() . '_' . $image->getClientOriginalName();

                $route = public_path() . '/images/products';

                $image->move($route, $name);

                $urlimages[]['url'] = '/images/products/' . $name;
            }
        }

        $prod = $this->getModel();

        $prod->name = $data->name;
        $prod->slug = $data->slug;
        $prod->category_id = $data->category_id;
        $prod->quantity = $data->quantity;
        $prod->price = $data->price;
        $prod->description = $data->description;
        $prod->specifications = $data->specifications;
        $prod->data_of_interest = $data->data_of_interest;
        $prod->status = $data->status;

        $prod->save();

        $prod->images()->createMany($urlimages);
    }

    /**
     * show product
     *
     * @param string $slug
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getProductbySlug(string $slug): Model
    {
        return $this->getModel()->with('images', 'category')
            ->where('slug', $slug)->firstOrFail();
    }

    /**
     * Function for update products
     *
     * @param $data
     * @param string $id
     */
    public function updateProduct(object $data, string $id)
    {
        $urlimages = [];
        if ($data->hasFile('images')) {
            $images = $data->file('images');

            foreach ($images as $image) {
                $name = time() . '_' . $image->getClientOriginalName();

                $route = public_path() . '/images/products';

                $image->move($route, $name);

                $urlimages[]['url'] = '/images/products/' . $name;
            }
        }

        $prod = $this->getModel()->findOrFail($id);

        $prod->name = $data->name;
        $prod->slug = $data->slug;
        $prod->category_id = $data->category_id;
        $prod->quantity = $data->quantity;
        $prod->price = $data->price;
        $prod->description = $data->description;
        $prod->specifications = $data->specifications;
        $prod->data_of_interest = $data->data_of_interest;
        $prod->status = $data->status;

        $prod->save();

        $prod->images()->createMany($urlimages);
    }

    /**
     * function to select the product category
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function categoryForProduct(): Collection
    {
        return Category::orderBy('name')->get();
    }
}
