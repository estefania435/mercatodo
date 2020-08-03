<?php

namespace App\Http\Controllers;

use Exception;
use PhpParser\Node\Stmt\TryCatch;
use ReflectionExtension;
use Illuminate\Support\Facades\Log;
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
        try {
            $name = $request->get('name');

            $products = Product::with('images', 'category')
                ->where('name', 'like', "%$name%")->orderBy('name')->paginate(env('PAGINATE'));
            Log::channel('contlog')->info('listar productos');

            return view('home', compact('products'));
        }catch (\Exception $e) {
            Log::channel('contlog')->error("Error al listar los productos ".
                 "getMessage: ".$e->getMessage().
                 " - getFile: ".$e->getFile().
                 " - getLine: ".$e->getLine());

            return view('welcome');
        }
    }
}
