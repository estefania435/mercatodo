<?php

use Illuminate\Support\Facades\Route;
use App\MercatodoModels\User;
use App\MercatodoModels\Role;
use App\MercatodoModels\Permission;
use Illuminate\Support\Facades\Gate;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified')
    ->middleware('auth');

Route::resource('/role', 'RoleController')->names('role');

Route::resource('/user', 'UserController', ['except' => [
    'create', 'store']])->names('user');

Route::post('restore/{id}', ['as' => 'user.restore', 'uses' => 'UserController@restore']);

Route::get('/admin', function () {
    return view('plantilla.admin');
})->name('admin');

Route::resource('admin/category', 'Admin\AdminCategoryController')->names('admin.category')->middleware('auth');

Route::resource('admin/product', 'Admin\AdminProductController')->names('admin.product')
    ->middleware('auth');

Route::get('cancel/{ruta}', function ($ruta) {
    return redirect()->route($ruta)->with('cancel', 'Action Canceled!');
})->name('cancel');

Route::post('restoreproduct/{id}', ['as' => 'admin.product.restore', 'uses'
=> 'Admin\AdminProductController@restore']);

Route::post('restorecategory/{id}', ['as' => 'admin.category.restore', 'uses'
=> 'Admin\AdminCategoryController@restore']);

Route::resource('/product', 'ProductController')->names('product');

Route::resource('admin/order', 'Admin\AdminOrderController')->names('admin.order');

Route::resource('admin/detail', 'Admin\AdminDetailController')->names('admin.detail');

Route::get('cart/show', [
    'as' => 'cart.show',
    'uses' => 'Admin\AdminCartController@show'
])->middleware('auth');

Route::get('cart/add/{id}', [
    'as' => 'cart.add',
    'uses' => 'Admin\AdminCartController@add'
])->middleware('auth');

Route::get('cart/delete/{id}', [
    'as' => 'cart.delete',
    'uses' => 'Admin\AdminCartController@delete'
]);

Route::get('cart/trash', [
    'as' => 'cart.trash',
    'uses' => 'Admin\AdminCartController@trash'
]);

Route::get('cart/update/{slug}/{quantity?}', [
    'as' => 'cart.update',
    'uses' => 'Admin\AdminCartController@update'
]);

Route::get('order-detail', [
    'as' => 'order-detail',
    'uses' => 'Admin\AdminCartController@orderDetail'
]);

Route::post('cart/datesReceive', [
    'as' => 'cart.Datesreceive',
    'uses' => 'Admin\AdminCartController@Datesreceive'
]);

Route::get('pay/pay/{reference?}', [
    'as' => 'pay.pay',
    'uses' => 'Admin\AdminPayController@pay'
]);

Route::get('pay/data', [
    'as' => 'pay.data',
    'uses' => 'Admin\AdminPayController@data'
]);

Route::get('pay/consult/{reference?}', [
    'as' => 'pay.consult',
    'uses' => 'Admin\AdminPayController@consult'
]);

Route::get('pay/status', [
    'as' => 'pay.status',
    'uses' => 'Admin\AdminPayController@status'
]);

Route::get('pay/updatedata', [
    'as' => 'pay.updatedata',
    'uses' => 'Admin\AdminPayController@updatedata'
]);

Route::get('pay/show', [
    'as' => 'pay.show',
    'uses' => 'Admin\AdminPayController@show'
]);

Route::get('pay/updateorderstatus', [
    'as' => 'pay.updateorderstatus',
    'uses' => 'Admin\AdminPayController@updateorderstatus'
]);

Route::get('pay/showallorders', [
    'as' => 'pay.showallorders',
    'uses' => 'Admin\AdminPayController@showallorders'
]);

Route::get('pay/repay', [
    'as' => 'pay.repay',
    'uses' => 'Admin\AdminPayController@repay'
]);

Route::get('pay/reredirection', [
    'as' => 'pay.reredirection',
    'uses' => 'Admin\AdminPayController@reredirection'
]);
