<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\MercatodoModels\Product;

class ProductController extends Controller
{
    public function index()
    {
        return Product::all();
    }

    public function show($slug)
    {
        if (product::where('slug', $slug)->first()) {
            return 'Slug exist';
        } else {
            return 'Slug available';
        }
    }
}
