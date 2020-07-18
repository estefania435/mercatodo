<?php

use Illuminate\Support\Facades\Route;
use App\User;
use App\MercatodoPermission\Models\Role;
use App\MercatodoPermission\Models\Permission;
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
    return view('welcome');
});


Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');


Route::get('/test', function () {
    $user=User::find(1);
    //$user->roles()->sync([8]);
    Gate::authorize('haveaccess', 'role.show');
    return $user;
    //return $user->havePermission('role.create');
});

Route::resource('/role', 'RoleController')->names('role');

Route::resource('/user', 'UserController', ['except'=>[
    'create','store']])->names('user');
Route::post('restore/{id}', [ 'as' => 'user.restore', 'uses' => 'UserController@restore']);

Route::get('/admin', function (){
        return view('plantilla.admin');
});

Route::resource('admin/category','Admin\AdminCategoryController')->names('admin.category');
