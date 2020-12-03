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

class ProductController extends Controller
{
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
        $product = Product::withTrashed('images', 'category')
            ->orderBy('name')->get();

        return response()->json($product, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug
     * @return JsonResponse
     */
    public function ShowAProduct(string $slug): JsonResponse
    {
        $this->authorize('haveaccess', 'admin.product.show');

        $product = Product::with('images', 'category')
            ->where('slug', $slug)->firstOrFail();

        return response()->json($product, 200);
    }

    /**
     * create a new product
     *
     * @param ProductStoreRequest $request
     * @return JsonResponse
     */
    public function createProduct(ProductStoreRequest $request): JsonResponse
    {
        $this->authorize('haveaccess', 'admin.product.create');

        $prod = new Product();

        $prod->name = $request->name;
        $prod->slug = $request->slug;
        $prod->category_id = $request->category_id;
        $prod->quantity = $request->quantity;
        $prod->price = $request->price;
        $prod->description = $request->description;
        $prod->specifications = $request->specifications;
        $prod->data_of_interest = $request->data_of_interest;
        $prod->status = $request->status;

        $prod->save();

        $image = new Image();
        $image->url = $request->url ;
        $image->imageable_type = $request->imageable_type;
        $image->imageable_id = $prod->id;
        $image->save();

        return response()->json(["message" => "Product create successfully"], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function updateProduct(ProductUpdateRequest $request, int $id): JsonResponse
    {
        $this->authorize('haveaccess', 'admin.product.edit');

        $prod = Product::findOrFail($id);

        $prod->name = $request->name;
        $prod->slug = $request->slug;
        $prod->category_id = $request->category_id;
        $prod->quantity = $request->quantity;
        $prod->price = $request->price;
        $prod->description = $request->description;
        $prod->specifications = $request->specifications;
        $prod->data_of_interest = $request->data_of_interest;
        $prod->status = $request->status;

        $prod->save();

        $imageExist = Image::where('url', $request->url)->where('imageable_id', $prod->id)->first();

        if (!$imageExist) {
            $image = new Image();
            $image->url = $request->url;
            $image->imageable_type = $request->imageable_type;
            $image->imageable_id = $prod->id;
            $image->save();
        }

        return response()->json(["message" => "Product successfully updated"], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function deleteProduct(int $id): JsonResponse
    {
        $this->authorize('haveaccess', 'admin.product.destroy');

        if (Product::where('id', $id)->exists()) {
            $p = Product::find($id);
            $p->delete();
            return response()->json(["message" => "Product delete successfully"], 200);
        } else {
            return response()->json(["message" => "Product not exist"], 404);
        }
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function restore(int $id): JsonResponse
    {
        $this->authorize('haveaccess', 'admin.product.restore');

        Product::withTrashed()->find($id)->restore();

        return response()->json(["message" => "Product restore successfully"], 200);
    }
}
