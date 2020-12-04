<?php

namespace App\Http\Controllers;

use App\Repositories\cart\CartRepository;
use App\Repositories\product\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\MercatodoModels\Category;

class HomeController extends Controller
{
    protected $cartShowRepo;
    protected $prodRepo;

    /**
     * AdminCategoryController constructor.
     *
     * @param ProductRepository $prodRepository
     */
    public function __construct(ProductRepository $prodRepository, CartRepository $cartRepository)
    {
        $this->prodRepo = $prodRepository;
        $this->cartShowRepo = $cartRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $products = $this->prodRepo->getAllProduct($request);
        $cart = $this->cartShowRepo->getProductsOfCart();
        $category = Category::cachedCategories();

        return view('home', compact('products', 'cart', 'category'));
    }
}
