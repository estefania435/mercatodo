<?php

namespace App\Repositories\category;

use App\MercatodoModels\Category;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Helpers\Paginator;

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
    public function getAllCategories(Request $request)
    {
        /*$name = $data->get('name');

        return $this->getModel()->withTrashed('category')
            ->where('name', 'like', "%$name%")->orderBy('name')->paginate(1);*/

        return Paginator::paginate($request, Category::cachedCategories());
    }

    /**
     * function for create category
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createCategory(array $data): Model
    {
        Category::flushCache();

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
        Category::flushCache();
        Log::channel('contlog')->info('La categoria: ' .
            $object->name . ' ' . 'ha sido editada por: ' . ' ' .
            Auth::user()->name . ' ' . Auth::user()->surname);

        return $object;
    }
}
