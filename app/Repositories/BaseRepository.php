<?php

namespace App\Repositories;

use App\MercatodoModels\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

abstract class BaseRepository
{
    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    abstract public function getModel();

    /**
     * Function for find by Id
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findId(int $id): Model
    {
        return $this->getModel()->find($id);
    }

    /**
     * see the products
     *
     * @param object $data
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllProduct(Request $request): LengthAwarePaginator
    {
        $name = $request->get('searchbyname');
        $price = $request->get('searchbyprice');
        $category = $request->get('searchbycategory');

        return $this->getModel()->withTrashed('images', 'category')
            ->name($name)->price($price)->category($category)->orderBy('name')->paginate(env('PAGINATE'));
    }

    /**
     * Function for see producst of cart
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getProductsOfCart()
    {
        return $this->getModel()->with('details.products', 'details.products.images')
            ->done()->first();
    }

    /**
     * Function for delete product or category
     *
     * @param $object
     */
    public function delete(object $object)
    {
        $object->delete();
    }

    /**
     * Function for restore product or category
     *
     * @param $data
     * @return bool
     */
    public function restore(Request $data): bool
    {
        return $this->getModel()->withTrashed()->find($data->id)->restore();
    }
}
