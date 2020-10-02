<?php

namespace App\Repositories\category;

use App\MercatodoModels\Category;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class CategoryRepository extends BaseRepository
{
    /**
     * @return Category
     */
    public function getModel(): Category
    {
        return new Category();
    }

    /**
     * get category by slug
     *
     * @param string $slug
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findCategory(string $slug): Model
    {
        return $this->getModel()->where('slug', $slug)->firstOrFail();
    }

    /**
     * get all categories
     *
     * @param object $data
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllCategories(object $data): LengthAwarePaginator
    {
        $name = $data->get('name');

        return $this->getModel()->withTrashed('category')
            ->where('name', 'like', "%$name%")->orderBy('name')->paginate(env('PAGINATE'));
    }

    /**
     * function for create category
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createCategory(array $data): Model
    {
        return $this->getModel()->create($data);
    }

    /**
     * Functiomn for update categories
     *
     * @param object $object
     * @param array $data
     * @return object
     */
    public function updateCategory(object $object, array $data): object
    {
        $object->fill($data);
        $object->save();

        return $object;
    }
}
