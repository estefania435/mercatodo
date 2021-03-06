<?php

namespace App\Repositories\product;

use App\Exports\ProductExport;
use App\Exports\ReportProducts;
use App\Imports\importMultipleSheets;
use App\Imports\ProductImport;
use App\Jobs\NotifyUserOfCompletedReport;
use App\MercatodoModels\Category;
use App\MercatodoModels\Product;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

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
     * see the products
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllProductAdmin(Request $request): LengthAwarePaginator
    {
        if (empty($request->all())) {
            return $this->getModel()->withTrashed('images', 'category')
                ->orderBy('name')->paginate(env('PAGINATE'));
        } else {
            $isInactive = $request->get('searchbyisInactive');

            $category = $request->get('searchbycategory');

            return $this->getModel()->withTrashed('images', 'category')
                ->isinactive($isInactive)->category($category)->orderBy('name')->paginate(env('PAGINATE'));
        }
    }

    /**
     * function for create product
     *
     * @param array $data
     */
    public function createProduct(Request $data): void
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

        Log::channel('contlog')->info('El producto: ' .
            $prod->name . ' ' . 'ha sido creado por: ' . ' ' .
            Auth::user()->name . ' ' . Auth::user()->surname);
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
    public function updateProduct(Request $data, string $id): void
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
        $category = Category::where('name', $data->category_id)->first();


        $prod = $this->getModel()->findOrFail($id);

        $prod->name = $data->name;
        $prod->slug = $data->slug;
        $prod->category_id = $category->id;
        $prod->quantity = $data->quantity;
        $prod->price = $data->price;
        $prod->description = $data->description;
        $prod->specifications = $data->specifications;
        $prod->data_of_interest = $data->data_of_interest;
        $prod->status = $data->status;

        $prod->save();


        $prod->images()->createMany($urlimages);

        Log::channel('contlog')->info('El producto: ' .
            $prod->name . ' ' . 'ha sido editado por: ' . ' ' .
            Auth::user()->name . ' ' . Auth::user()->surname);
    }

    /**
     * function to select the product category
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function categoryForProduct(): Collection
    {
        return Category::cachedCategories();
    }

    /**
     * Import products and images in bulk
     *
     * @param Request $request
     * @return array
     */
    public function importProduct(Request $request): array
    {
        $import = new ProductImport();
        $import->import($request->file('importFile'));
        $importedProducts = $import->toArray($request->file('importFile'));

        Log::channel('contlog')->info('El usuario ' .
            Auth::user()->name . ' ' . Auth::user()->surname . ' ' .
            'ha importado una lista de productos');

        return $importedProducts;
    }

    /**
     * Export products and images in bulk
     *
     * @param Request $request
     * @return
     */
    public function productExport()
    {
        return Excel::download(new ProductExport(), 'products.xlsx');
    }

    /**
     * report of products
     *
     * @param Request $request
     * @return void
     */
    public function productReport(Request $request): void
    {
        (new ReportProducts($request->all()))->queue('ReportOfproducts.xlsx')->chain([
            new NotifyUserOfCompletedReport(request()->user()),
        ]);

        Log::channel('contlog')->info('El usuario ' .
            Auth::user()->name . ' ' . Auth::user()->surname . ' ' .
            'ha generado un reporte de productos');
    }
}
