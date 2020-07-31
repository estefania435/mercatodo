<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MercatodoModels\Product;

class ProductController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id): \Illuminate\View\View
    {
        $product = Product::find($id);

        return view('product.show', compact('product'));
    }
}
