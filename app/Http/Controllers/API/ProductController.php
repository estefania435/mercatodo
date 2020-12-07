<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\MercatodoModels\Image;
use App\MercatodoModels\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use App\Repositories\Api\ApiProductRepository;

class ProductController extends Controller
{
    protected $apiRepo;

    /**
     * api Controller constructor.
     * @param ApiProductRepository $ApiProductRepository
     */
    public function __construct(ApiProductRepository $ApiProductRepository)
    {
        $this->apiRepo = $ApiProductRepository;
    }

    /**
     * list all products
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index(): Collection
    {
        return Product::all();
    }

    /**
     * verify if slug exist
     *
     * @param string $slug
     * @return string
     */
    public function show(string $slug): string
    {
        if (product::where('slug', $slug)->first()) {
            return 'Slug exist';
        } else {
            return 'Slug available';
        }
    }

    /**
     * Display a listing of the products.
     *
     * @return JsonResponse
     */
    public function showAllProducts(): JsonResponse
    {
        return $this->apiRepo->showProducts();
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug
     * @return JsonResponse
     */
    public function showProduct(string $slug): JsonResponse
    {
        $this->authorize('haveaccess', 'admin.product.show');

        return $this->apiRepo->seeAProduct($slug);
    }

    /**
     * create a new product
     *
     * @param ProductStoreRequest $request
     * @return JsonResponse
     */
    public function create(ProductStoreRequest $request): JsonResponse
    {
        $this->authorize('haveaccess', 'admin.product.create');

        return $this->apiRepo->createProduct($request);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param ProductUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(ProductUpdateRequest $request, string $slug): JsonResponse
    {
        $this->authorize('haveaccess', 'admin.product.edit');

        return $this->apiRepo->updateProduct($request, $slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function delete(string $slug): JsonResponse
    {
        $this->authorize('haveaccess', 'admin.product.destroy');

        return $this->apiRepo->deleteProduct($slug);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function restore(string $slug): JsonResponse
    {
        $this->authorize('haveaccess', 'admin.product.restore');

        return $this->apiRepo->restoreProduct($slug);
    }
}
