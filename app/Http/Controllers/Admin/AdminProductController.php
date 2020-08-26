<?php

namespace App\Http\Controllers\Admin;

use Exception;
use PhpParser\Node\Stmt\TryCatch;
use ReflectionExtension;
use Illuminate\Support\Facades\Log;
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
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): \Illuminate\View\View
    {
        try {
            $this->authorize('haveaccess', 'admin.product.index');

            $name = $request->get('name');

            $products = Product::withTrashed('images', 'category')
            ->where('name', 'like', "%$name%")->orderBy('name')->paginate(env('PAGINATE'));
            Log::channel('contlog')->info('listar productos');

            return view('admin.product.index', compact('products'));
        } catch (\Exception $e) {
            Log::channel('contlog')->error("Error al listar los productos ".
                "getMessage: ".$e->getMessage().
                " - getFile: ".$e->getFile().
                " - getLine: ".$e->getLine());

            return view('welcome');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(): \Illuminate\View\View
    {
        $this->authorize('haveaccess', 'admin.product.create');

        $this->authorize('haveaccess', 'admin.category.create');

        $statusProducts = $this->statusProducts;

        $categories = Category::orderBy('name')->get();

        return view('admin.product.create', compact('categories', 'statusProducts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductStoreRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('haveaccess', 'admin.product.create');

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
     * Display the specified resource.
     *
     * @param string $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(string $slug): \Illuminate\View\View
    {
        $this->authorize('haveaccess', 'admin.product.show');

        $product = Product::with('images', 'category')->where('slug', $slug)->firstOrFail();

        $categories = Category::orderBy('name')->get();

        $statusProducts = $this->statusProducts;

        return view('admin.product.show', compact('product', 'categories', 'statusProducts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(string $slug): \Illuminate\View\View
    {
        $this->authorize('haveaccess', 'admin.product.edit');

        $product = Product::with('images', 'category')->where('slug', $slug)->firstOrFail();

        $categories = Category::orderBy('name')->get();

        $statusProducts = $this->statusProducts;

        return view('admin.product.edit', compact('product', 'categories', 'statusProducts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductUpdateRequest $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductUpdateRequest $request, string $id): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('haveaccess', 'admin.product.edit');

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
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('haveaccess', 'admin.product.destroy');

        $product = Product::find($id);
        $product->delete();

        return redirect()->route('admin.product.index')
            ->with('data', 'Product disabled');
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(Request $request): \Illuminate\Http\RedirectResponse
    {
        Product::withTrashed()->find($request->id)->restore();

        return redirect()->route('admin.product.index')
            ->with('data', 'Product  enabled');
    }
}
