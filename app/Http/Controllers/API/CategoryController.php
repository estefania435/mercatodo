<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\MercatodoModels\Category;

class CategoryController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param string $slug
     * @return string
     */
    public function show(string $slug): string
    {
        if (Category::where('slug', $slug)->first()) {
            return 'Slug exist';
        } else {
            return 'Slug available';
        }
    }
}
