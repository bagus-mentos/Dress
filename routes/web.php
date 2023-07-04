<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Route::get('/dashboard', function () {
    return view('layouts.components.dashboard');
});

Route::get('/home', function () {
    return view('layouts.components.dashboard');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::resource('account', AccountController::class);
    Route::get('getAccount', [AccountController::class, 'getAccount'])->name('account.getAccount');

    Route::resource('customer', CustomerController::class);
    Route::get('getCustomer', [CustomerController::class, 'getCustomer'])->name('customer.getCustomer');

    Route::resource('order', OrderController::class);
    Route::get('getOrder', [OrderController::class, 'getOrder'])->name('order.getOrder');

    Route::resource('product', ProductController::class);
    Route::get('getProduct', [ProductController::class, 'getProduct'])->name('product.getProduct');
    Route::get('getSubCategory/{id}', [ProductController::class, 'getSubCategory'])->name('product.getSubCategory');
});
