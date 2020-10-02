<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

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
    public function getAllProduct(object $data): LengthAwarePaginator
    {
        $name = $data->get('name');

        return $this->getModel()->withTrashed('images', 'category')
            ->where('name', 'like', "%$name%")->orderBy('name')->paginate(env('PAGINATE'));
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
    public function restore(object $data): bool
    {
        return $this->getModel()->withTrashed()->find($data->id)->restore();
    }
}
