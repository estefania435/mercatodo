<?php

namespace App\Repositories\Api;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\MercatodoModels\Category;
use App\MercatodoModels\Image;
use App\MercatodoModels\Product;
use App\Repositories\BaseRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiProductRepository extends BaseRepository
{
    /**
     * @return Product
     */
    public function getModel(): Product
    {
        return new Product();
    }

    /**
     * Display a listing of the products.
     *
     * @return JsonResponse
     */
    public function showProducts(): JsonResponse
    {
        $product = Product::withTrashed('images', 'category')
            ->orderBy('name')->get();

        return response()->json($product, 200);
    }

    public function seeAProduct(string $slug)
    {
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
    public function createProduct(Request $request): JsonResponse
    {
        $category = Category::where('name', $request->category_id)->first();
        $prod = new Product();

        $prod->name = $request->name;
        $prod->slug = $request->slug;
        $prod->category_id = $category->id;
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

        return response()->json(['message' => 'Product create successfully'], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function updateProduct(Request $request, string $slug): JsonResponse
    {
        $category = Category::where('name', $request->category_id)->first();
        $prod = Product::where('slug', $slug)->first();

        $prod->name = $request->name;
        $prod->slug = $request->slug;
        $prod->category_id = $category->id;
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

        return response()->json(['message' => 'Product successfully updated'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function deleteProduct(string $slug): JsonResponse
    {
        if (Product::where('slug', $slug)->exists()) {
            $p = Product::where('slug', $slug)->first();
            $p->delete();
            return response()->json(['message' => 'Product delete successfully'], 200);
        } else {
            return response()->json(['message' => 'Product not exist'], 404);
        }
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function restoreProduct(string $slug): JsonResponse
    {
        Product::withTrashed()->where('slug', $slug)->first()->restore();

        return response()->json(['message' => 'Product restore successfully'], 200);
    }
}
