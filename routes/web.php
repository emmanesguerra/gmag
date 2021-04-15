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

Route::get('/changepswd', 'ChangePasswordController@index')->name('changepswd');
Route::post('/changepswd', 'ChangePasswordController@store')->name('changepswd.store');

use App\Library\Modules\MembersLibrary;
Route::get('/test-search', function() {
    MembersLibrary::searchForTodaysPair(1);
});

Route::get('set-yesterdays-pair-type', 'ScheduleController@checkTodaysPairs')->name('set.yesterdays.pair.type');

Route::middleware('auth:web,admin')->group(function () {
    Route::middleware('mustchanged')->group(function () {
        Route::view('/home', 'home');

        Route::get('/gtree', 'GenealogyTreeController@index')->name('gtree.index');
        Route::post('/gtree/member-data', 'GenealogyTreeController@member_data')->name('gtree.member.data');
        Route::get('/gtree-pairing', 'GenealogyTreeController@pairing')->name('gtree.pairing');
        Route::get('/register-member', 'RegisterMemberController@create')->name('register.member.create');
        Route::post('/register-member', 'RegisterMemberController@store')->name('register.member.store');
        
        Route::get('/gtree/genealogy-list', 'GenealogyTreeController@genealogy')->name('gtree.genealogy');
        Route::get('/gtree/binary-list', 'GenealogyTreeController@binary')->name('gtree.binary');
        Route::get('/gtree/binary-list-left', 'GenealogyTreeController@binaryleft')->name('gtree.binary.left');
        Route::get('/gtree/binary-list-right', 'GenealogyTreeController@binaryright')->name('gtree.binary.right');
        
        Route::get('/change-password', 'ChangePasswordController@indexIn')->name('changepassword.index');
        Route::post('/change-password', 'ChangePasswordController@storeIn')->name('changepassword.store');
        
        Route::get('/profile/{id}/edit', 'ProfileController@edit')->name('profile.edit');
        Route::put('/profile/{id}', 'ProfileController@update')->name('profile.update');
        
        Route::get('/transaction-bonus', 'TransactionsController@bonus')->name('transactions.bonus');
    });
    
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
        
        Route::get('/members', 'Admin\MembersController@index')->name('admin.member.index');
        Route::get('/members/{slug}', 'Admin\MembersController@show')->name('admin.member.show');
        Route::get('/members/{slug}/edit', 'Admin\MembersController@edit')->name('admin.member.edit');
        
        Route::get('/transactions', 'Admin\TransactionsController@index')->name('admin.transactions.index');
        Route::get('/transaction-bonus', 'Admin\TransactionsController@bonus')->name('admin.transactions.bonus');
    });
});