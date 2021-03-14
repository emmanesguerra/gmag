<?php

use Illuminate\Support\Facades\Route;

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
    return redirect('/login');
});

Auth::routes();

Route::get('/login/admin', 'Auth\LoginController@showAdminLoginForm');
Route::get('/register/admin', 'Auth\RegisterController@showAdminRegisterForm');

Route::post('/login/admin', 'Auth\LoginController@adminLogin');

Route::middleware('auth:web,admin')->group(function () {
    Route::view('/home', 'home');
    
    Route::middleware('auth:admin')->group(function () {
        Route::view('/admin', 'admin.home');
        
        Route::get('/control-panel', 'Admin\ControlPanelController@index')->name('admin.controlpanel.index');
        Route::post('/control-panel', 'Admin\ControlPanelController@store')->name('admin.controlpanel.store');
        
        Route::get('/change-admin-password', 'Admin\ChangeAdminPassword@index')->name('admin.changepassword.index');
        Route::post('/change-admin-password', 'Admin\ChangeAdminPassword@store')->name('admin.changepassword.store');
        
        Route::get('/products', 'Admin\ProductsController@index')->name('admin.products.index');
        Route::get('/products/create', 'Admin\ProductsController@create')->name('admin.products.create');
        Route::post('/products', 'Admin\ProductsController@store')->name('admin.products.store');
        Route::get('/products/{slug}', 'Admin\ProductsController@show')->name('admin.products.show');
        Route::get('/products/{slug}/edit', 'Admin\ProductsController@edit')->name('admin.products.edit');
        Route::put('/products/{slug}', 'Admin\ProductsController@update')->name('admin.products.update');
    });
});