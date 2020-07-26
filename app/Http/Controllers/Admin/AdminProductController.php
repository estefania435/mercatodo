<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\MercatodoModels\Product;
use App\MercatodoModels\Category;
use Illuminate\Http\Request;
use App\Http\Requests\ProductStoreRequest;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ProductUpdateRequest;

/**
 * Class AdminProductController
 * @package App\Http\Controllers\Admin
 */
class AdminProductController extends Controller
{
    /**
     * @var string[]
     */
    public $statusProducts = array('', 'New', 'Offer');

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $name = $request->get('name');

        $products = Product::withTrashed('images', 'category')
            ->where('name', 'like', "%$name%")->orderBy('name')->paginate(10);


        return view('admin.product.index', compact('products'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $statusProducts = $this->statusProducts;


        $categories = Category::orderBy('name')->get();

        return view('admin.product.create', compact('categories', 'statusProducts'));
    }

    /**
     * @param ProductStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductStoreRequest $request)
    {
        $urlimages = [];
        if ($request->hasFile('images')) {
            $images = $request->file('images');

            foreach ($images as $image) {
                $name = time() . '_' . $image->getClientOriginalName();

                $route = public_path() . '/images/products';

                $image->move($route, $name);

                $urlimages[]['url'] = '/images/products/' . $name;
            }
        }

        $prod = new Product;

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

        $prod->images()->createMany($urlimages);

        return redirect()->route('admin.product.index')
            ->with('data', 'Record created successfully!');
    }

    /**
     * @param string $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(string $slug)
    {
        $product = Product::with('images', 'category')->where('slug', $slug)->firstOrFail();

        $categories = Category::orderBy('name')->get();

        $statusProducts = $this->statusProducts;


        return view('admin.product.show', compact('product', 'categories', 'statusProducts'));
    }

    /**
     * @param string $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(string $slug)
    {
        $product = Product::with('images', 'category')->where('slug', $slug)->firstOrFail();

        $categories = Category::orderBy('name')->get();

        $statusProducts = $this->statusProducts;


        return view('admin.product.edit', compact('product', 'categories', 'statusProducts'));
    }

    /**
     * @param ProductUpdateRequest $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductUpdateRequest $request, string $id)
    {
        $urlimages = [];
        if ($request->hasFile('images')) {
            $images = $request->file('images');

            foreach ($images as $image) {
                $name = time() . '_' . $image->getClientOriginalName();

                $route = public_path() . '/images/products';

                $image->move($route, $name);

                $urlimages[]['url'] = '/images/products/' . $name;
            }
        }

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

        $prod->images()->createMany($urlimages);

        return redirect()->route('admin.product.edit', $prod->slug)
            ->with('data', 'Record updated successfully!');
    }

    /**
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        $product->delete();

        return redirect()->route('admin.product.index')
            ->with('data', 'Product disabled');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(Request $request)
    {
        Product::withTrashed()->find($request->id)->restore();

        return redirect()->route('admin.product.index')
            ->with('data', 'Product  enabled');
    }
}
