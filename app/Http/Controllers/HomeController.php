<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MercatodoModels\Product;
use App\MercatodoModels\Category;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request): \Illuminate\View\View
    {
        $name = $request->get('name');

        $products = Product::with('images', 'category')
        ->where('name', 'like', "%$name%")->orderBy('name')->paginate(env('PAGINATE'));

        return view('home', compact('products'));
    }
}
