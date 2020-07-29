<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MercatodoModels\Product;
use App\MercatodoModels\Category;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $name = $request->get('name');

        $products = Product::with('images', 'category')
            ->where('name', 'like', "%$name%")->orderBy('name')->paginate(9);

        //$products = \App\MercatodoModels\Product::paginate(10);
            return view('home', compact('products'));
    }

}
