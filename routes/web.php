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
    
    Route::get('/gtree', 'GenealogyTreeController@index')->name('gtree.index');
    Route::post('/gtree/member-data', 'GenealogyTreeController@member_data')->name('gtree.member.data');
        
    
    Route::middleware('auth:admin')->prefix('admin')->group(function () {
        Route::view('/dashboard', 'admin.home');
        
        Route::get('/control-panel', 'Admin\ControlPanelController@index')->name('admin.controlpanel.index');
        Route::post('/control-panel', 'Admin\ControlPanelController@store')->name('admin.controlpanel.store');
        
        Route::get('/change-admin-password', 'Admin\ChangeAdminPassword@index')->name('admin.changepassword.index');
        Route::post('/change-admin-password', 'Admin\ChangeAdminPassword@store')->name('admin.changepassword.store');
        
        Route::get('/products', 'Admin\ProductsController@index')->name('admin.products.index');
        Route::get('/products/create', 'Admin\ProductsController@create')->name('admin.products.create');
        Route::post('/products', 'Admin\ProductsController@store')->name('admin.products.store');
        Route::get('/products/{slug}', 'Admin\ProductsController@show')->name('admin.products.show');
        Route::get('/products/{slug}/edit', 'Admin\ProductsController@edit')->name('admin.products.edit');
        Route::put('/products/{id}', 'Admin\ProductsController@update')->name('admin.products.update');
        
        Route::get('/entry-codes', 'Admin\RegistrationCodesController@index')->name('admin.entrycodes.index');
        Route::get('/entry-codes/create', 'Admin\RegistrationCodesController@create')->name('admin.entrycodes.create');
        Route::post('/entry-codes', 'Admin\RegistrationCodesController@store')->name('admin.entrycodes.store');
        Route::get('/entry-codes/{id}', 'Admin\RegistrationCodesController@show')->name('admin.entrycodes.show');
        Route::get('/entry-codes/{id}/edit', 'Admin\RegistrationCodesController@edit')->name('admin.entrycodes.edit');
        Route::put('/entry-codes/{id}', 'Admin\RegistrationCodesController@update')->name('admin.entrycodes.update');
        Route::delete('/entry-codes/{id}', 'Admin\RegistrationCodesController@destroy')->name('admin.entrycodes.delete');
    });
});