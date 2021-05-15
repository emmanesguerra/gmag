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

Route::middleware('auth:web')->group(function () {
    Route::middleware('mustchanged')->group(function () {
        Route::get('/home', 'HomeController@index')->name('home');
        Route::get('/home-earnings', 'HomeController@earnings')->name('home.earnings');
        
        Route::get('/refresh-account', 'RefeshController@index')->name('refresh.index');
        Route::post('/refresh-account', 'RefeshController@store')->name('refresh.store');

        Route::get('/gtree', 'GenealogyTreeController@index')->name('gtree.index');
        Route::get('/gtree-pairing', 'GenealogyTreeController@pairing')->name('gtree.pairing');
        Route::get('/gtree-pairing/{id}/data', 'GenealogyTreeController@pairingdata')->name('gtree.pairing.data');
        Route::get('/register-member', 'RegisterMemberController@create')->name('register.member.create');
        Route::post('/register-member', 'RegisterMemberController@store')->name('register.member.store');
        
        Route::get('/gtree/genealogy-list', 'GenealogyTreeController@genealogy')->name('gtree.genealogy');
        Route::get('/gtree/genealogy-list/{id}/data', 'GenealogyTreeController@genealogydata')->name('gtree.genealogydata');
        Route::get('/gtree/binary-list', 'GenealogyTreeController@binary')->name('gtree.binary');
        Route::get('/gtree/binary-list-left', 'GenealogyTreeController@binaryleft')->name('gtree.binary.left');
        Route::get('/gtree/binary-list-right', 'GenealogyTreeController@binaryright')->name('gtree.binary.right');
        
        Route::get('/change-password', 'ChangePasswordController@indexIn')->name('changepassword.index');
        Route::post('/change-password', 'ChangePasswordController@storeIn')->name('changepassword.store');
        
        Route::get('/profile/{id}', 'ProfileController@show')->name('profile.show');
        Route::get('/profile/{id}/edit', 'ProfileController@edit')->name('profile.edit');
        Route::put('/profile/{id}', 'ProfileController@update')->name('profile.update');
        Route::get('/profile/{id}/cycle', 'ProfileController@cycle')->name('profile.cycle');
        Route::get('/profile/{id}/purchased', 'ProfileController@purchased')->name('profile.purchased');
        
        Route::get('/transaction-bonus', 'TransactionsController@bonus')->name('transactions.bonus');
        Route::get('/transaction-bonus/{id}/data', 'TransactionsController@bonusdata')->name('transactions.bonusdata');
        
        Route::get('/switch', 'SwitchController@index')->name('switch.index');
        Route::get('/switch/data', 'SwitchController@data')->name('switch.data');
        Route::get('/switch-acount/{id?}', 'SwitchController@switchaccount')->name('switch.account');
        
        Route::get('/ewallet', 'WalletController@index')->name('wallet.index');
        Route::post('/ewallet-request', 'WalletController@postEncashment')->name('wallet.post');
        Route::get('/ewallet-history', 'WalletController@history')->name('wallet.history');
        Route::get('/ewallet-history-data/{id}', 'WalletController@historydata')->name('wallet.history.data');
        
        Route::get('/courses', 'CoursesController@index')->name('course.index');
        
        Route::get('/code-vault', 'CodeVaultController@index')->name('codevault.index');
        Route::get('/code-vault/{id}/data', 'CodeVaultController@data')->name('codevault.data');
        Route::get('/code-vault/purchase', 'CodeVaultController@purchaseform')->name('codevault.purchaseform');
        Route::post('/code-vault/purchase', 'CodeVaultController@purchase')->name('codevault.purchase');
    });
});

Route::middleware('auth:admin')->prefix('admin')->group(function () {
    Route::view('/dashboard', 'admin.home');

    Route::get('/control-panel', 'Admin\ControlPanelController@index')->name('admin.controlpanel.index');
    Route::post('/control-panel', 'Admin\ControlPanelController@store')->name('admin.controlpanel.store');

    Route::get('/change-admin-password', 'Admin\ChangeAdminPassword@index')->name('admin.changepassword.index');
    Route::post('/change-admin-password', 'Admin\ChangeAdminPassword@store')->name('admin.changepassword.store');

    Route::get('/change-members-username', 'Admin\ChangeMemberUsername@index')->name('admin.memberusername.index');
    Route::post('/change-members-username', 'Admin\ChangeMemberUsername@store')->name('admin.memberusername.store');

    Route::get('/products', 'Admin\ProductsController@index')->name('admin.products.index');
    Route::get('/products-data', 'Admin\ProductsController@data')->name('admin.products.data');
    Route::get('/products/create', 'Admin\ProductsController@create')->name('admin.products.create');
    Route::post('/products', 'Admin\ProductsController@store')->name('admin.products.store');
    Route::get('/products/{slug}', 'Admin\ProductsController@show')->name('admin.products.show');
    Route::get('/products/{slug}/edit', 'Admin\ProductsController@edit')->name('admin.products.edit');
    Route::put('/products/{id}', 'Admin\ProductsController@update')->name('admin.products.update');

    Route::get('/entry-codes', 'Admin\RegistrationCodesController@index')->name('admin.entrycodes.index');
    Route::get('/entry-codes/data', 'Admin\RegistrationCodesController@data')->name('admin.entrycodes.data');
    Route::get('/entry-codes-used', 'Admin\RegistrationCodesController@used')->name('admin.entrycodes.used');
    Route::get('/entry-codes-used/data', 'Admin\RegistrationCodesController@useddata')->name('admin.entrycodes.useddata');
    Route::get('/entry-codes/create', 'Admin\RegistrationCodesController@create')->name('admin.entrycodes.create');
    Route::post('/entry-codes', 'Admin\RegistrationCodesController@store')->name('admin.entrycodes.store');
    Route::get('/entry-codes/{id}', 'Admin\RegistrationCodesController@show')->name('admin.entrycodes.show');
    Route::get('/entry-codes/{id}/edit', 'Admin\RegistrationCodesController@edit')->name('admin.entrycodes.edit');
    Route::put('/entry-codes/{id}', 'Admin\RegistrationCodesController@update')->name('admin.entrycodes.update');
    Route::delete('/entry-codes/{id}', 'Admin\RegistrationCodesController@destroy')->name('admin.entrycodes.delete');

    Route::get('/members', 'Admin\MembersController@index')->name('admin.member.index');
    Route::get('/members/data', 'Admin\MembersController@data')->name('admin.member.data');
    Route::get('/members/{id}', 'Admin\MembersController@show')->name('admin.member.show');
    Route::get('/members/{id}/edit', 'Admin\MembersController@edit')->name('admin.member.edit');
    Route::get('/members-visit', 'Admin\MembersController@visit')->name('admin.member.visit');
    Route::get('/members-visit-data', 'Admin\MembersController@visitdata')->name('admin.member.visitdata');
    Route::get('/members/{id}/cycle', 'Admin\MembersController@cycle')->name('admin.member.cycle');
    Route::get('/members/{id}/purchased', 'Admin\MembersController@purchased')->name('admin.member.purchased');
    Route::put('/members/{id}', 'Admin\MembersController@update')->name('admin.member.update');

    Route::get('/transactions', 'Admin\TransactionsController@index')->name('admin.transactions.index');
    Route::get('/transactions-data', 'Admin\TransactionsController@data')->name('admin.transactions.data');
    Route::get('/transaction-bonus', 'Admin\TransactionsController@bonus')->name('admin.transactions.bonus');
    Route::get('/transaction-bonus-data', 'Admin\TransactionsController@bonusdata')->name('admin.transactions.bonusdata');
    
    Route::get('/encashment-requests', 'Admin\EncashmentController@index')->name('admin.encashment.index');
    Route::get('/encashment-data', 'Admin\EncashmentController@data')->name('admin.encashment.data');
    Route::post('/encashment-approve', 'Admin\EncashmentController@approve')->name('admin.encashment.approve');
    Route::delete('/encashment-reject', 'Admin\EncashmentController@reject')->name('admin.encashment.reject');
    
    Route::get('/courses/data', 'Admin\CoursesController@getdata')->name('admin.course.data');
    Route::get('/courses', 'Admin\CoursesController@index')->name('admin.course.index');
    Route::get('/courses/create', 'Admin\CoursesController@create')->name('admin.course.create');
    Route::post('/courses', 'Admin\CoursesController@store')->name('admin.course.store');
    Route::get('/courses/{id}/edit', 'Admin\CoursesController@edit')->name('admin.course.edit');
    Route::put('/courses/{id}', 'Admin\CoursesController@update')->name('admin.course.update');
    Route::delete('/courses/{id}', 'Admin\CoursesController@destroy')->name('admin.course.destroy');
});