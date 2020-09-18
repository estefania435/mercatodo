<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MercatodoModels\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\View\View
     */
    public function show($id): View
    {
        $product = Product::find($id);

        return view('product.show', compact('product'));
    }
}
