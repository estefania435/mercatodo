<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\MercatodoModels\Product;

class ProductController extends Controller
{
    /**
     * @return Product[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        return Product::all();
    }

    /**
     * @param string $slug
     * @return string
     */
    public function show(string $slug): string
    {
        if (product::where('slug', $slug)->first()) {
            return 'Slug exist';
        } else {
            return 'Slug available';
        }
    }
}
