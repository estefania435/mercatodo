<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('category', 'API\CategoryController')->names('api.category');

Route::apiResource('product', 'API\ProductController')->names('api.product');

Route::get('/autocomplete', 'API\AutocompleteController@autocomplete')->name('autocomplete');

Route::get('Product', 'API\ProductController@showAllProducts');

Route::get('Product/{slug}', 'API\ProductController@ShowAProduct');

Route::post('Product', 'API\ProductController@createProduct');

Route::delete('Product/{id}', 'API\ProductController@deleteProduct');

Route::put('Product/{id}', 'API\ProductController@updateProduct');

Route::post('Product/{id}', 'API\ProductController@restore');
