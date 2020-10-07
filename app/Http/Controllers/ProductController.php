<?php

namespace App\Http\Controllers;

use App\Repositories\product\ProductRepository;
use Illuminate\View\View;

class ProductController extends Controller
{
    protected $productsRepo;

    /**
     * AdminCategoryController constructor.
     *
     * @param ProductRepository $productsRepository
     */
    public function __construct(ProductRepository $productsRepository)
    {
        $this->productsRepo = $productsRepository;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show(int $id): View
    {
        $product = $this->productsRepo->findId($id);

        return view('product.show', compact('product'));
    }
}
