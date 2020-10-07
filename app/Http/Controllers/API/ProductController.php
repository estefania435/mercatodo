<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\MercatodoModels\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductController extends Controller
{
    /**
     * list all products
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index(): Collection
    {
        return Product::all();
    }

    /**
     * verify if slug exist
     *
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
