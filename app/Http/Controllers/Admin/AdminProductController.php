<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ProductExport;
use App\Exports\ReportProducts;
use App\Http\Controllers\Controller;
use App\Http\Requests\Products\ImportRequest;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Imports\ProductImport;
use App\Imports\importMultipleSheets;
use App\MercatodoModels\Category;
use App\Repositories\product\ProductRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class AdminProductController extends Controller
{
    protected $productRepo;

    /**
     * AdminCategoryController constructor.
     * @param ProductRepository $categoryRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepo = $productRepository;
    }

    /**
     * @var string[]
     */
    public $statusProducts = ['', 'New', 'Offer'];

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $products = $this->productRepo->getAllProductAdmin($request);
        $category = Category::orderBy('name')->get();

        $request = $request->all();

        return view('admin.product.index', compact('products', 'category', 'request'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        $this->authorize('haveaccess', 'admin.product.create');

        $statusProducts = $this->statusProducts;

        $categories = $this->productRepo->categoryForProduct();

        return view('admin.product.create', compact('categories', 'statusProducts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductStoreRequest $request): RedirectResponse
    {
        $this->authorize('haveaccess', 'admin.product.create');

        $this->productRepo->createProduct($request);

        return redirect()->route('admin.product.index')
            ->with('data', 'Record created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function show(string $slug): View
    {
        $this->authorize('haveaccess', 'admin.product.show');

        $product = $this->productRepo->getProductbySlug($slug);

        $statusProducts = $this->statusProducts;

        return view('admin.product.show', compact('product', 'statusProducts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function edit(string $slug): View
    {
        $this->authorize('haveaccess', 'admin.product.edit');

        $product = $this->productRepo->getProductbySlug($slug);

        $statusProducts = $this->statusProducts;

        return view('admin.product.edit', compact('product', 'statusProducts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductUpdateRequest $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductUpdateRequest $request, string $id): RedirectResponse
    {
        $this->authorize('haveaccess', 'admin.product.edit');

        $prod = $this->productRepo->updateProduct($request, $id);

        return redirect()->route('admin.product.edit', $prod->id)
            ->with('data', 'Record updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id): RedirectResponse
    {
        $this->authorize('haveaccess', 'admin.product.destroy');

        $product = $this->productRepo->findId($id);
        $this->productRepo->delete($product);

        return redirect()->route('admin.product.index')
            ->with('data', 'Product disabled');
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(Request $request): RedirectResponse
    {
        $this->productRepo->restore($request);

        return redirect()->route('admin.product.index')
            ->with('data', 'Product  enabled');
    }

    /**
     * Import products and images in bulk
     *
     * @param ImportRequest $request
     * @return RedirectResponse
     */
    public function import(ImportRequest $request): RedirectResponse
    {
        $this->productRepo->ImportProduct($request);

        return redirect()->back()->with('data', 'Se han importado los productos de manera correcta');
    }

    /**
     * Export products and images in bulk
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function exportProduct(Request $request): RedirectResponse
    {
        $this->productRepo->productExport($request);

        return redirect()->back()->with('data', 'Se han exportado los productos de manera correcta');
    }

    /**
     * report of products
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function reportProduct(Request $request): RedirectResponse
    {
        $this->productRepo->productReport($request);

        return redirect()->back()->with('data', 'Reporte generado correctamente');
    }
}
